<?php

namespace App\Namespaces;

use Discord\Parts\Channel\Message;
use Discord\Parts\Embed\Embed;
use Discord\Discord;

class DefaultEmbed {

    public $color = '57F287';
    public $result;

    public function __construct(Message $message, Discord $discord, array $options = [])
    {
        if(isset($options['color']))
            $this->color = $options['color'];

        $content = [
            'color' => hexdec($this->color),
            'author' => [
                'name' => $message->author->user->username,
                'icon_url' => $message->author->user->avatar
            ],
        ];

        if(isset($options['description']))
            $content['description'] = $options['description'];

        if(isset($options['title']))
            $content['title'] = $options['title'];

        $this->result = new Embed($discord, $content, true);
    } 

}
