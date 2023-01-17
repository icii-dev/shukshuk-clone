<?php

namespace App\Http\Controllers\WebHook;

use App\Service\ShippingService;
use Illuminate\Http\Request;

class ShipmentController
{
    public function callback(Request $request, ShippingService $shippingService)
    {
        $referrerId = $request->get('waybill');
        $request->get('booking_id');

        if (!$shipping = $shippingService->getShippingByReferrerId($referrerId)) {
            \Log::error(
                sprintf('Unhandled shipping #%s', $referrerId),
                $request->all()
            );

            return response()->json([
                "status" => 400,
                "info" => "Error",
                "content" => "The waybill is invalid"
            ], 400);
        }

        try {
            $shippingService->addHistoryFromPayload($shipping, $request->all());
        } catch (\Exception $exception){
            return response()->json([
                "status" => 500,
                "info" => "Error",
                "content" => $exception->getMessage()
            ], 500);
        }

        return response()->json([
            "status" => 200,
            "info" => "OK",
            "content" => []
                ]);
    }
}
