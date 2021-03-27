<?php

namespace App\GraphQL\Queries;

class HelloWorld
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke ($_, array $args) {
        return 'This is a simple hello world query';
    }

    public function index ($_, array $args) {
        return 'This is a simple hello world Index';
    }
    
}
