<?php

namespace App\GraphQL\Queries;

class Qualification
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        return 
            ['id'=>1,'name'=>'Temp'];
    }
}
