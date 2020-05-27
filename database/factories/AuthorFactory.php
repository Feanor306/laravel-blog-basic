<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Author;
use Faker\Generator as Faker;

$factory->define(Author::class, function (Faker $faker) {
    return [
        //
    ];
});

// Generate Profile after creating Author for 1-to-1 relationship
$factory->afterCreating(App\Author::class, function ($author, $faker) {
    $genProfile = factory(App\Profile::class)->make();
    $author->profile()->save($genProfile);
});

// Called before saving
// $factory->afterMaking(App\Author::class, function ($author, $faker) {
//     $genProfile = factory(App\Profile::class)->make();
//     $author->profile()->save($genProfile);
// });