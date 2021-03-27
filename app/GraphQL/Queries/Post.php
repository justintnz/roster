<?php

namespace App\GraphQL\Queries;
use Faker\Factory as Faker;
class Post
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
    $faker =  Faker::create();
    $data =[];
    for ($i=0;$i<10;$i++)
    {
        $data[]  = [
            'id'        => $args['id'], // id from the argument.
            'title'     => $faker->sentence(10),
            'slug'      => $faker->slug,
            'rating'    => $faker->randomFloat(),
            'author'    => $faker->name,
            'anonymous' => $faker->randomDigit % 2 == 0,
        ];
    }
    return $data;   }
}
