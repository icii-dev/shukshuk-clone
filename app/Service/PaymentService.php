<?php

namespace App\Service;

use App\Model\Disbursement;
use App\Model\Payment;
use Xendit\Xendit;

class PaymentService {

    function __construct () {
        $this->server_domain = env('XENDIT_DOMAIN', '');
        $this->secret_api_key = env('XENDIT_API_KEY', '');
    }

    function createInvoice ($external_id, $amount, $payer_email, $description, $invoice_options = null) {
        $curl = curl_init();
        $headers = array();
        $headers[] = 'Content-Type: application/json';

        $end_point = $this->server_domain.'/v2/invoices';

        $data['external_id'] = $external_id;
        $data['amount'] = $amount;
        $data['payer_email'] = $payer_email;
        $data['description'] = $description;
//        $invoice_options['success_redirect_url'] = "http://localhost:8000/checkout";
        if ( is_array($invoice_options) ) {
            foreach ( $invoice_options as $key => $value ) {
                $data[$key] = $value;
            }
        }

        $payload = json_encode($data);

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_USERPWD, $this->secret_api_key.":");
        curl_setopt($curl, CURLOPT_URL, $end_point);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);
        curl_close($curl);

        $responseObject = json_decode($response, true);
        return $responseObject;
    }

    function createPayment($paymentResponse, $paymentFee){
        return $payment = Payment::create([
            'id' => $paymentResponse['id'],
            'status' => $paymentResponse['status'],
            'currency' => $paymentResponse['currency'],
            'invoice_url' => $paymentResponse['invoice_url'],
            'paid_amount' => $paymentResponse['amount'],
            'payment_fee' => $paymentFee
        ]);
    }

    function getInvoice ($invoice_id) {
        $curl = curl_init();

        $headers = array();
        $headers[] = 'Content-Type: application/json';

        $end_point = $this->server_domain.'/v2/invoices/'.$invoice_id;

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_USERPWD, $this->secret_api_key.":");
        curl_setopt($curl, CURLOPT_URL, $end_point);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);
        curl_close($curl);

        $responseObject = json_decode($response, true);
        return $responseObject;
    }

    function createDisbursement(Disbursement $disbursement){
        Xendit::setApiKey($this->secret_api_key);

         $params = [
            'external_id' => (string)$disbursement->id,
            'amount' => $disbursement->amount,
            'bank_code' => $disbursement->bank_code,
            'account_holder_name' => $disbursement->account_holder_name,
            'account_number' => $disbursement->account_number,
            'description' => 'SHUK - ' . $disbursement->description,
            'X-IDEMPOTENCY-KEY' => (string)$disbursement->id
        ];

         try {
             $createDisbursements = \Xendit\Disbursements::create($params);
         } catch (\Exception $exception) {
             return ['error' => $exception->getMessage()];
         }

         return $createDisbursements;
    }

    function getAvailableBanks(){
        Xendit::setApiKey($this->secret_api_key);

        $banks = \Xendit\Disbursements::getAvailableBanks();

        return $banks;
    }

    //return total + fee
    function addFeePayment($total, $paymentMethod = ["CREDIT_CARD"]){
        return $total + $this->getFeePayment($total, $paymentMethod);
    }

    //return only fee
    function getFeePayment($total, $paymentMethod = ["CREDIT_CARD"]){
        if(in_array("CREDIT_CARD", $paymentMethod)){
            return (FLOOR($total + (0.0319*$total + 2200)/0.9681) - $total);
        }

        if(in_array("OVO", $paymentMethod) || in_array("DANA", $paymentMethod)){
            return FLOOR(0.0165*$total);
        }

        return 4950;
    }
}