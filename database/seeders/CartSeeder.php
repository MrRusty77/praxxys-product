<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Faker\Generator as Faker;

use App\Models\Users;
use App\Models\Product;
use App\Models\Cart;


class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker )
    {

        Cart::create([
            'user_id' => Users::all()->random()->id,
            'product_id' => Product::all()->random()->id,
            'qty' => $faker->randomDigit(),
        ]);
    }
}
