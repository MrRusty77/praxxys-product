<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;

use App\Models\Product;


class ProductSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Product::create([ 
            'name' => 'Product1',
            'code' => rand(10,10),
            'hash' => Hash::make('Product1'),
            'img_path' => 'milk_carton.png',
            'category_id' => 1,
        ]);
        
        Product::create([ 
            'name' => 'Product2',
            'code' => rand(10,10),
            'hash' => Hash::make('Product2'),
            'img_path' => 'milk_carton.png',
            'category_id' => 2,
        ]);

        Product::create([ 
            'name' => 'Product3',
            'code' => rand(10,10),
            'hash' => Hash::make('Product3'),
            'img_path' => 'milk_carton.png',
            'category_id' => 3,
        ]);

        Product::create([ 
            'name' => 'Product4',
            'code' => rand(10,10),
            'hash' => Hash::make('Product4'),
            'img_path' => 'milk_carton.png',
            'category_id' => 4,
        ]);

        Product::create([ 
            'name' => 'Product5',
            'code' => rand(10,10),
            'hash' => Hash::make('Product5'),
            'img_path' => 'milk_carton.png',
            'category_id' => 5,
        ]);

        Product::create([ 
            'name' => 'Product6',
            'code' => rand(10,10),
            'hash' => Hash::make('Product6'),
            'img_path' => 'milk_carton.png',
            'category_id' => 6,
        ]);

        Product::create([ 
            'name' => 'Product6',
            'code' => rand(10,10),
            'hash' => Hash::make('Product6'),
            'img_path' => 'milk_carton.png',
            'category_id' => 6,
        ]);

        Product::create([ 
            'name' => 'Product7',
            'code' => rand(10,10),
            'hash' => Hash::make('Product7'),
            'img_path' => 'milk_carton.png',
            'category_id' => 7,
        ]);

        Product::create([ 
            'name' => 'Product8',
            'code' => rand(10,10),
            'hash' => Hash::make('Product8'),
            'img_path' => 'milk_carton.png',
            'category_id' => 8,
        ]);

        Product::create([ 
            'name' => 'Product9',
            'code' => rand(10,10),
            'hash' => Hash::make('Product9'),
            'img_path' => 'milk_carton.png',
            'category_id' => 9,
        ]);

        Product::create([ 
            'name' => 'Product10',
            'code' => rand(10,10),
            'hash' => Hash::make('Product10'),
            'img_path' => 'milk_carton.png',
            'category_id' => 10,
        ]);

        Product::create([ 
            'name' => 'Product11',
            'code' => rand(10,10),
            'hash' => Hash::make('Product11'),
            'img_path' => 'milk_carton.png',
            'category_id' => 11,
        ]);

        Product::create([ 
            'name' => 'Product12',
            'code' => rand(10,10),
            'hash' => Hash::make('Product12'),
            'img_path' => 'milk_carton.png',
            'category_id' => 12,
        ]);

        Product::create([ 
            'name' => 'Product13',
            'code' => rand(10,10),
            'hash' => Hash::make('Product13'),
            'img_path' => 'milk_carton.png',
            'category_id' => 13,
        ]);

        Product::create([ 
            'name' => 'Product14',
            'code' => rand(10,10),
            'hash' => Hash::make('Product14'),
            'img_path' => 'milk_carton.png',
            'category_id' => 14,
        ]);

        Product::create([ 
            'name' => 'Product15',
            'code' => rand(10,10),
            'hash' => Hash::make('Product15'),
            'img_path' => 'milk_carton.png',
            'category_id' => 15,
        ]);

        Product::create([ 
            'name' => 'Product16',
            'code' => rand(10,10),
            'hash' => Hash::make('Product16'),
            'img_path' => 'milk_carton.png',
            'category_id' => 16,
        ]);
    }
}
