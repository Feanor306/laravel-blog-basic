<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(6),
        'content' => $faker->paragraphs(5, true)
    ];
});

// Can choose only a set of fields to have custom content
// The rest will be generated by faker
$factory->state(App\Post::class, 'new-title', function (Faker $faker){
    return [
        'title' => 'New title',
        'content' => 'New Content'
    ];
});