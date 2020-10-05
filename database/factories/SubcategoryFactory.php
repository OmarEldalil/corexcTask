<?php

/** @var Factory $factory */

use App\Category;
use App\Subcategory;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Subcategory::class, function (Faker $faker) {
    return [
        'name' => $faker->text,
        'category_id'=> factory(Category::class)
    ];
});
