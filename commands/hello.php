<?php

new \App\Command([
    'name' => 'hello',
    'aliases' => ['run', 'test'],
    'ownerOnly' => false,
    'run' => function($message, $rest) {
        $message->channel->sendMessage("Hello !");
    },
]);