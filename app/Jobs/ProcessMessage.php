<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use PhpAmqpLib\Message\AMQPMessage;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class ProcessMessage implements ShouldQueue
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
    public function handle()
    {
        $connection = new AMQPStreamConnection(env('RABBITMQ_HOST'), 5672, env('RABBITMQ_USER'), env('RABBITMQ_PASSWORD'));
        $channel = $connection->channel();

        $channel->queue_declare('default', false, true, false, false);

        $msg = new AMQPMessage('Hello from Laravel!');
        $channel->basic_publish($msg, '', 'default');

        $channel->close();
        $connection->close();
    }
}
