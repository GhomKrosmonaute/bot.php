<?php

new \App\Command([
    'name' => 'eval',
    'aliases' => ['run', 'test'],
    'ownerOnly' => true,
    'run' => function($message, $rest) {
        try {
            $result = eval(trim($rest).';');
            var_dump($result);
    
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
    },
]);