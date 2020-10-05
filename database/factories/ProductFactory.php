<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'title' => $faker->text,
        'description' => $faker->text,
        'img_url' => (rand(0,10)>5)? 'oil.jpg': 'filter.jpg',
        'price' => $faker->randomFloat(null, 0 , 100.00),
        'quantity' => $faker->numberBetween(0, 100),
        'subcategory_id'=> factory(\App\Subcategory::class),
        'brand_id' => factory(\App\Brand::class)
    ];
});
