<?php

namespace App;

class Command
{
    public static $commands = [];

    public $name;
    public $description;
    public $aliases = [];
    public $ownerOnly;

    public $run;

    public function __construct(array $options)
    {
        if(!isset($options['name']))
            throw new \Error("Missing name property on some Command");

        if(!isset($options['description']))
            throw new \Error('Missing description property on some Command');

        if(!isset($options['run']))
            throw new \Error('Missing run property on "'.$options['name'].'" Command');

        $this->name = $options['name'];
        $this->description = $options['description'];
        $this->run = $options['run'];

        if(isset($options['aliases'])) $this->aliases = $options['aliases'];
        if(isset($options['ownerOnly'])) $this->ownerOnly = $options['ownerOnly'];

        self::$commands[$options['name']] = $this;
        
    }

}