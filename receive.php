<?php 

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

// create conneciton
// $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$connection = new AMQPStreamConnection('10.30.8.40', 5672, 'admin', 'Kopnus789clear', '/my_vhost');
$channel = $connection->channel();

$channel->queue_declare('hello', false, false, false, false);

echo " [*] Waiting for messages. To exit press CTRL+C\n";

$callback = function ($msg) {
    $data = json_decode($msg->body);
    echo ' [v] Nama ', $data->nama, "\n";
    echo ' [v] Nama ', $data->email, "\n\n";
};

$channel->basic_consume('hello', '', false, true, false, false, $callback);

while ($channel->is_open()) {
    $channel->wait();
}

$channel->close();
$connection->close();