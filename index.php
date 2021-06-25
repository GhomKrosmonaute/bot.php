<?php

include __DIR__.'/vendor/autoload.php';

use Dotenv\Dotenv;
use Discord\Discord;
use Discord\Parts\Channel\Message;
use App\Command;

Dotenv::createImmutable(__DIR__)->load();

define("PREFIX", $_ENV["PREFIX"]);

foreach (glob("commands/*.php") as $filename) require_once $filename;
foreach (glob("listeners/*.php") as $filename) require_once $filename;

try {
    $client = new Discord([
        'token' => $_ENV['TOKEN'],
    ]);

    $client->on('ready', function (Discord $client) {
        echo "Bot is ready!", PHP_EOL;

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
                            if($message->author->id != '780814951228244018') {
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
    });

    $client->run();
} catch (\Discord\Exceptions\IntentException $e) {
    echo $e->getMessage(), PHP_EOL;
}