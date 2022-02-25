
<?php 

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

// create conneciton
$connection = new AMQPStreamConnection('127.0.0.1', 5672, 'guest', 'guest', '/my_vhost');
$channel = $connection->channel();

$channel->queue_declare('hello', false, false, false, false);

$data = ['nama' => 'Galih Anggoro Jati', 'email' => 'galih@email.com'];

$msg = new AMQPMessage(json_encode($data));
$channel->basic_publish($msg, '', 'hello');

echo " [x] Sent Data to RabbitMQ Success\n";

$channel->close();
$connection->close();