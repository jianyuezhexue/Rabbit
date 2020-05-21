<?php

require_once __DIR__ . '../../vendor/autoload.php';

putenv('TEST_AMQP_DEBUG=1');

define('HOST', getenv('TEST_RABBITMQ_HOST') ? getenv('TEST_RABBITMQ_HOST') : '10.0.75.2'); // 10.0.75.2为docker容器的地址 默认localhost
define('PORT', getenv('TEST_RABBITMQ_PORT') ? getenv('TEST_RABBITMQ_PORT') : 5672);
define('USER', getenv('TEST_RABBITMQ_USER') ? getenv('TEST_RABBITMQ_USER') : 'guest');
define('PASS', getenv('TEST_RABBITMQ_PASS') ? getenv('TEST_RABBITMQ_PASS') : 'guest');
define('VHOST', '/');
define('AMQP_DEBUG', getenv('TEST_AMQP_DEBUG') !== false ? (bool) getenv('TEST_AMQP_DEBUG') : false);
