<?php

namespace App;

class Command
{
    public static array $commands = [];

    public string $name;
    public ?array $aliases;
    public ?bool $ownerOnly;
    public $run;

    public function __construct($options)
    {
        if(!isset($options['name']))
            throw new \Error("Missing name property on some Command");

        if(!isset($options['run']))
            throw new \Error('Missing run property on "'.$options['name'].'" Command');

        $this->name = $options['name'];
        $this->run = $options['run'];

        if(isset($options['aliases'])) $this->aliases = $options['aliases'];
        if(isset($options['ownerOnly'])) $this->ownerOnly = $options['ownerOnly'];

        self::$commands[$options['name']] = $this;
    }
}