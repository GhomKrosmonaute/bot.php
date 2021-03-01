<?php

include __DIR__.'/vendor/autoload.php';

use Dotenv\Dotenv;
use Discord\Discord;
use Discord\Parts\Channel\Message;

Dotenv::createImmutable(__DIR__)->load();

define("PREFIX", $_ENV["PREFIX"]);

function is(string $command, string $name): bool {
    return str_starts_with($command, $name);
}

function crop(string $command, string $name): string {
    return substr($command, strlen($name));
}

try {
    $client = new Discord([
        'token' => $_ENV['TOKEN'],
    ]);

    $client->on('ready', function ($discord) {
        echo "Bot is ready!", PHP_EOL;

        // Listen for messages.
        $discord->on('message', function (Message $message) {
            if($message->type != Message::TYPE_NORMAL)
                return;

            if(str_starts_with($message->content, PREFIX)){
                $cmd = substr($message->content, 1);

                // Handle eval command
                if(is($cmd, "eval")){
                    if($message->author->id == "352176756922253321"){
                        try {
                            $result = eval(crop($cmd, "eval").';');

                            if(is_null($result)){
                                $message->channel->sendMessage("Done.");
                            }else{
                                $stringResult = strval($result);
                                $message->channel->sendMessage("```php\n$stringResult\n```");
                            }
                        }catch (ParseError $error){
                            $errorMessage = $error->getMessage();
                            $message->channel->sendMessage("```pbp\nParseError: $errorMessage\n```");
                        }
                    }else{
                        $message->channel->sendMessage("Nope.");
                    }
                }
            }
        });
    });

    $client->run();
} catch (\Discord\Exceptions\IntentException $e) {
    echo $e->getMessage(), PHP_EOL;
}