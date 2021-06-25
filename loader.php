<?php

use Discord\Discord;
use Discord\Parts\Channel\Message;
use App\Command;
use App\Listener;

// Listen for messages.
$client->on('message', function (Message $message, Discord $client) {
    if($message->type != Message::TYPE_NORMAL) return null;

    if(str_starts_with($message->content, PREFIX)){
        $without_prefix = substr($message->content, 1);

        foreach(Command::$commands as $command){
            // Handle eval command
            if(str_starts_with($without_prefix, $command->name)){
                // Check owner
                if($command->ownerOnly){
                    if($message->author->id != $_ENV['OWNER']) {
                        return $message->channel->sendMessage("Nope.");
                    }
                }

                $rest = substr($without_prefix, strlen($command->name));

                // Tkt c'est normal x)
                // Il demande en premier arg un obj puis les args de la fonction, donc le pourquoi du comment le voila.
                $command->run->call($message, $message, $rest);

            }
        }
    }
});

// Listener for events
foreach(Listener::$events as $event) {
    $client->on($event->listener, $event->run);
}