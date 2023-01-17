<?php

namespace App\Console\Commands;

use App\Events\OrderPayForSeller;
use App\Model\Order;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SellerTransactionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sellerTransactionCommand:payOrder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pay orders for seller';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $orders = Order::where('status', '=', Order::STATUS_COMPLETED)
                        ->where('pay_for_seller', '=', Order::UNPAID_TO_SELLER)
                         ->get();
        \Log::channel('transaction')->info('Run command pay for seller ' . $orders);
        foreach ($orders as $order){
            $now = Carbon::now();
            //pay for order success 3 day
            if($now->subDay(3) > $order->orderShipping->expect_finish){
                try {
                    event(new OrderPayForSeller($order));
                    \Log::channel('transaction')->info('pay for seller success:  ' . $order->id);
                }catch (\Exception $exception){
                    \Log::channel('transaction')->error('Error when Pay for seller ' . $order->id . ' -Error: ' . $exception->getMessage());
                }
            }
        }
    }
}
