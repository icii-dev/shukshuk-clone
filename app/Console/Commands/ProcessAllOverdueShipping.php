<?php

namespace App\Console\Commands;

use App\Service\ShippingService;
use Illuminate\Console\Command;

class ProcessAllOverdueShipping extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-all-overdue-shipping';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find & process shipping is not completed after 1 ';

    /**
     * @var ShippingService
     */
    private $shippingService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ShippingService $shippingService)
    {
        parent::__construct();

        $this->shippingService = $shippingService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        \Log::channel('processAllOverdueShipping')->info('Start tracking orders: ');
        $this->shippingService->processAllOverdueShipping();
    }
}
