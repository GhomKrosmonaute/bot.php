<?php

include __DIR__.'/vendor/autoload.php';

use Dotenv\Dotenv;
use Discord\Discord;

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

        require_once 'app/Handler.php';
        
    });

    $client->run();
} catch (\Discord\Exceptions\IntentException $e) {
    echo $e->getMessage(), PHP_EOL;
}