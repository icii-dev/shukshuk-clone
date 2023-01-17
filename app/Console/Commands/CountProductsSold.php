<?php

namespace App\Console\Commands;

use App\Model\OrderProduct;
use App\Service\OrderService;
use Illuminate\Console\Command;

class CountProductsSold extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:count-sold';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private $orderService;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(OrderService $orderService)
    {
        parent::__construct();
        $this->orderService = $orderService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $orderProducts = OrderProduct::all();
        foreach ($orderProducts as $orderProduct){
            $this->orderService->updateProductSold($orderProduct->product_id, $orderProduct->quantity);
        }
    }
}
