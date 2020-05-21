<?php

include(__DIR__ . '/config.php');

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;

$exchange = 'router'; // 交换机
$queue = 'msgs'; // 队列名


// 连接
$connection = new AMQPStreamConnection(HOST, PORT, USER, PASS, VHOST);
// 创建channel（$channel_id = null）
$channel = $connection->channel();

/*
    The following code is the same both in the consumer and the producer.
    In this way we are sure we always have a queue to consume from and an
        exchange where to publish messages.
*/

/*
    name: $queue
    passive: false
    durable: true // the queue will survive server restarts
    exclusive: false // the queue can be accessed in other channels
    auto_delete: false //the queue won't be deleted once the channel is closed.
*/
// 声明队列
$channel->queue_declare($queue, false, true, false, false);

/*
    name: $exchange
    type: direct
    passive: false
    durable: true // the exchange will survive server restarts
    auto_delete: false //the exchange won't be deleted once the channel is closed.
*/
// 声明交换机
$channel->exchange_declare($exchange, AMQPExchangeType::DIRECT, false, true, false);
// 交换机绑定队列
$channel->queue_bind($queue, $exchange);

// $messageBody = implode(' ', array_slice($argv, 1));
// 信息体
$messageBody = 'RabbtiMQ 第一个实例！';
// 让客户端退出
// $messageBody = 'quit'; 
// 消息实例
$message = new AMQPMessage($messageBody, array('content_type' => 'text/plain', 'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT));
// 推送消息
$channel->basic_publish($message, $exchange);

// 关闭通道
$channel->close();
// 关闭连接
$connection->close();
