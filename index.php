<?php

include __DIR__.'/vendor/autoload.php';

use Discord\Discord;
use Dotenv\Dotenv;

Dotenv::createImmutable(__DIR__)->load();

define("PREFIX", $_ENV["PREFIX"]);

try {
    $client = new Discord([
        'token' => $_ENV['TOKEN'],
    ]);

    $client->on('ready', function ($discord) {
        echo "Bot is ready!", PHP_EOL;

        // Listen for messages.
        $discord->on('message', function (\Discord\Parts\Channel\Message $message) {
            if(str_starts_with($message->content, PREFIX)){
                $command = substr($message->content, 1);
                $message->reply("The command is $command");
            }
        });
    });

    $client->run();
} catch (\Discord\Exceptions\IntentException $e) {
    echo $e->getMessage(), PHP_EOL;
}