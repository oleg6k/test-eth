<?php
//https://github.com/ratchetphp/Pawl
//https://github.com/sc0Vu/web3.php

use React\EventLoop\Factory;

require __DIR__ . '/vendor/autoload.php';

$loop = Factory::create();
$reactConnector = new \React\Socket\Connector($loop, [
    'dns' => '8.8.8.8',
    'timeout' => 10
]);
$connector = new \Ratchet\Client\Connector($loop, $reactConnector);

$connector('ws://localhost:8546', ['protocol1', 'subprotocol2'], ['Origin' => 'http://localhost'])
    ->then(function(Ratchet\Client\WebSocket $conn) {
        
        $conn->on('message', function(\Ratchet\RFC6455\Messaging\MessageInterface $msg) use ($conn) {
            echo "Received: {$msg}\n";
            //$conn->close();
        });

        $conn->on('close', function($code = null, $reason = null) {
            echo "Connection closed ({$code} - {$reason})\n";
        });

        $msg = '{"id": 1, "method": "eth_subscribe", "params": ["logs", {"address": "0xEA674fdDe714fd979de3EdF0F56AA9716B898ec8"}]}';
        $conn->send($msg);
    }, function(\Exception $e) use ($loop) {
        echo "Could not connect: {$e->getMessage()}\n";
        $loop->stop();
    });

$loop->run();
