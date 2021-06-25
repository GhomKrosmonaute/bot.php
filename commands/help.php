<?php

use App\Command;
use App\Namespaces\DefaultEmbed;
use Discord\Parts\Channel\Message;

new App\Command([
    'name' => 'help',
    'description' => 'Help Command',
    'run' => function(Message $message, string $rest) {

        if(empty($rest)) {
            $commands = "Here are all my available orders:\n\n";

            foreach(Command::$commands as $command) {
                $commands .= "**".PREFIX.$command->name."** - ".$command->description."\n";
            }
    
            $embed = new DefaultEmbed($message, $message->discord, [
                'title' => 'Command List',
                'description' => $commands,
            ]);
    
            return $message->channel->sendEmbed($embed->result);
        } else {

            if(is_null(Command::$commands[$rest])) {
                $embed = new DefaultEmbed($message, $message->discord, [
                    'title' => 'Command ' . $rest,
                    'description' => 'Command Not Found',
                ]);
        
                return $message->channel->sendEmbed($embed->result);
            } else {

                if(Command::$commands[$rest]->aliases) {
                    $aliases = implode(", ", Command::$commands[$rest]->aliases);
                } else {
                    $aliases = "None";
                }

                $embed = new DefaultEmbed($message, $message->discord, [
                    'title' => 'Command ' . $rest,
                    'description' => "
                        **Description ** - ".Command::$commands[$rest]->description." \n**Aliases ** - ".$aliases."\n
                    ",
                ]);
        
                return $message->channel->sendEmbed($embed->result);
            }
        }

    }
]);