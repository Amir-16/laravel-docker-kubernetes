<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use PhpAmqpLib\Message\AMQPMessage;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class SendMessageToQueue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $connection = new AMQPStreamConnection('rabbitmq_server', 5672, 'guest', 'guest');
        $channel = $connection->channel();
        $channel->queue_declare('default', false, true, false, false);
        $msg = new AMQPMessage('Hello RabbitMQ!');
        $channel->basic_publish($msg, '', 'default');
        $channel->close();
        $connection->close();
    }
}
