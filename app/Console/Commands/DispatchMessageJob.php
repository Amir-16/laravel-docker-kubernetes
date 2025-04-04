<?php
namespace App\Console\Commands;

use App\Jobs\SendMessageToQueue;
use Illuminate\Console\Command;

class DispatchMessageJob extends Command
{
    protected $signature   = 'rabbitmq:send-message';
    protected $description = 'Dispatch SendMessageToQueue Job to RabbitMQ';

    public function handle()
    {
        dispatch(new SendMessageToQueue());
        $this->info('Message dispatched to RabbitMQ!');
    }
}
