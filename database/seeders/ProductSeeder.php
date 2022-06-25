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
            'description' => 'Product1',
            'code' => rand(10000000,99999999),
            'hash' => Hash::make('Product1'),
            'date_and_time' => date( 'Y-m-d H:i:s' ),
            'category_id' => 1,
        ]);
        
        Product::create([ 
            'name' => 'Product2',
            'description' => 'Product2',
            'code' => rand(10000000,99999999),
            'hash' => Hash::make('Product2'),
            'date_and_time' => date( 'Y-m-d H:i:s' ),
            'category_id' => 2,
        ]);

        Product::create([ 
            'name' => 'Product3',
            'description' => 'Product3',
            'code' => rand(10000000,99999999),
            'hash' => Hash::make('Product3'),
            'date_and_time' => date( 'Y-m-d H:i:s' ),
            'category_id' => 3,
        ]);

        Product::create([ 
            'name' => 'Product4',
            'description' => 'Product4',
            'code' => rand(10000000,99999999),
            'hash' => Hash::make('Product4'),
            'date_and_time' => date( 'Y-m-d H:i:s' ),
            'category_id' => 4,
        ]);

        Product::create([ 
            'name' => 'Product5',
            'description' => 'Product5',
            'code' => rand(10000000,99999999),
            'hash' => Hash::make('Product5'),
            'date_and_time' => date( 'Y-m-d H:i:s' ),
            'category_id' => 5,
        ]);

        Product::create([ 
            'name' => 'Product6',
            'description' => 'Product6',
            'code' => rand(10000000,99999999),
            'hash' => Hash::make('Product6'),
            'date_and_time' => date( 'Y-m-d H:i:s' ),
            'category_id' => 6,
        ]);

        Product::create([ 
            'name' => 'Product7',
            'description' => 'Product7',
            'code' => rand(10000000,99999999),
            'hash' => Hash::make('Product7'),
            'date_and_time' => date( 'Y-m-d H:i:s' ),
            'category_id' => 7,
        ]);

        Product::create([ 
            'name' => 'Product8',
            'description' => 'Product8',
            'code' => rand(10000000,99999999),
            'hash' => Hash::make('Product8'),
            'date_and_time' => date( 'Y-m-d H:i:s' ),
            'category_id' => 8,
        ]);

        Product::create([ 
            'name' => 'Product9',
            'description' => 'Product9',
            'code' => rand(10000000,99999999),
            'hash' => Hash::make('Product9'),
            'date_and_time' => date( 'Y-m-d H:i:s' ),
            'category_id' => 9,
        ]);

        Product::create([ 
            'name' => 'Product10',
            'description' => 'Product10',
            'code' => rand(10000000,99999999),
            'hash' => Hash::make('Product10'),
            'date_and_time' => date( 'Y-m-d H:i:s' ),
            'category_id' => 10,
        ]);

        Product::create([ 
            'name' => 'Product11',
            'description' => 'Product11',
            'code' => rand(10000000,99999999),
            'hash' => Hash::make('Product11'),
            'date_and_time' => date( 'Y-m-d H:i:s' ),
            'category_id' => 11,
        ]);

        Product::create([ 
            'name' => 'Product12',
            'description' => 'Product12',
            'code' => rand(10000000,99999999),
            'hash' => Hash::make('Product12'),
            'date_and_time' => date( 'Y-m-d H:i:s' ),
            'category_id' => 12,
        ]);

        Product::create([ 
            'name' => 'Product13',
            'description' => 'Product13',
            'code' => rand(10000000,99999999),
            'hash' => Hash::make('Product13'),
            'date_and_time' => date( 'Y-m-d H:i:s' ),
            'category_id' => 13,
        ]);

        Product::create([ 
            'name' => 'Product14',
            'description' => 'Product14',
            'code' => rand(10000000,99999999),
            'hash' => Hash::make('Product14'),
            'date_and_time' => date( 'Y-m-d H:i:s' ),
            'category_id' => 14,
        ]);

        Product::create([ 
            'name' => 'Product15',
            'description' => 'Product15',
            'code' => rand(10000000,99999999),
            'hash' => Hash::make('Product15'),
            'date_and_time' => date( 'Y-m-d H:i:s' ),
            'category_id' => 15,
        ]);

        Product::create([ 
            'name' => 'Product16',
            'description' => 'Product16',
            'code' => rand(10000000,99999999),
            'hash' => Hash::make('Product16'),
            'date_and_time' => date( 'Y-m-d H:i:s' ),
            'category_id' => 16,
        ]);

        Product::create([ 
            'name' => 'Product17',
            'description' => 'Product17',
            'code' => rand(10000000,99999999),
            'hash' => Hash::make('Product17'),
            'date_and_time' => date( 'Y-m-d H:i:s' ),
            'category_id' => 17,
        ]);
    }
}
