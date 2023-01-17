<?php

namespace App\Console\Commands;

use App\Model\Payment;
use App\Service\OrderService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Log;

class CheckOrdersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Orders Command';

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
    public function handle(OrderService $orderService)
    {
        Log::channel('order_history')->info("\n Start schedule check order");
        $cancelDate = Carbon::now()->subDay(1);
        $payments = Payment::where('status', Payment::STATUS_PENDING)
                            ->whereDate('created_at', "<=", $cancelDate)
                            ->get();
        foreach ($payments as $payment){
            $payment->status = Payment::STATUS_EXPIRED;
            $payment->save();
            $orders = $payment->orders;
            foreach ($orders as $order){
                $orderService->systemCancel($order);
            }
        }

        $inactiveOrders = $orderService->getInactiveOrders();
        foreach ($inactiveOrders as $order){
            $orderService->systemCancel($order);
        }

    }
}
