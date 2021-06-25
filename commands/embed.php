<?php

use App\Tools\DefaultEmbed;
use Discord\Parts\Channel\Message;

new App\Command([
    'name' => 'embed',
    'ownerOnly' => false,
    'run' => function(Message $message, $rest) {
        $embed = new DefaultEmbed($message, $message->discord, [
            'title' => 'test',
            'description' => 'This is an embed generation test',
        ]);
        $message->channel->sendEmbed($embed->embed);

    }
]);