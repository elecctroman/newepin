<?php

namespace App\Console\Commands;

use App\Jobs\RetryFailedDeliveryJob;
use App\Models\Order;
use Illuminate\Console\Command;

class RetryFailedOrdersCommand extends Command
{
    protected $signature = 'orders:retry-failed';
    protected $description = 'Dispatch retry jobs for failed supplier deliveries';

    public function handle(): int
    {
        Order::where('status', 'failed')->each(function (Order $order) {
            RetryFailedDeliveryJob::dispatch($order->id);
        });

        $this->info('Failed orders queued for retry.');

        return self::SUCCESS;
    }
}
