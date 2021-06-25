<?php

use Discord\Parts\Channel\Message;

new App\Command([
    'name' => 'say',
    'ownerOnly' => true,
    'run' => function(Message $message, $rest) {
        if(empty($rest)) 
            return $message->channel->sendMessage('You must pass a sentence');
        
        $message->delete();
        $message->channel->sendMessage($rest);
    }
]);