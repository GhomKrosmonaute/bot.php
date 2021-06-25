<?php

new \App\Command([
    'name' => 'hello',
    'aliases' => ['yo', 'bjr'],
    'ownerOnly' => false,
    'run' => function($message, $rest) {
        $message->channel->sendMessage("Hello !");
    },
]);