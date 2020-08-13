<?php

use App\Question;
use Faker\Generator as Faker;

$factory->define(Question::class, function (Faker $faker) {
    return [
        'title' => rtrim($faker->sentence(rand(5,10)),"."),
        'body' =>  $faker->paragraph(rand(3,7),true)
    ];
});
