<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;

use App\Models\Categories;
use App\Models\Users;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Categories::create(['name' => 'Category 1']);
        Categories::create(['name' => 'Category 2']);
        Categories::create(['name' => 'Category 3']);
        Categories::create(['name' => 'Category 4']);
        Categories::create(['name' => 'Category 5']);
        Categories::create(['name' => 'Category 6']);
        Categories::create(['name' => 'Category 7']);
        Categories::create(['name' => 'Category 8']);
        Categories::create(['name' => 'Category 9']);
        Categories::create(['name' => 'Category 10']);
        Categories::create(['name' => 'Category 11']);
        Categories::create(['name' => 'Category 12']);
        Categories::create(['name' => 'Category 13']);
        Categories::create(['name' => 'Category 14']);
        Categories::create(['name' => 'Category 15']);
        Categories::create(['name' => 'Category 16']);
        Categories::create(['name' => 'Category 17']);
        Categories::create(['name' => 'Category 18']);
        Categories::create(['name' => 'Category 19']);
        Categories::create(['name' => 'Category 20']);

        Users::create([ 
            'name' => 'dev',
            'username' => 'developer',
            'password' =>  Hash::make('developer'),
            'user_hash' => Hash::make( 'dev'.'developer' ),
        ]);

        Users::create([ 
            'name' => 'user 1',
            'username' => 'user1',
            'password' =>  Hash::make('user1'),
            'user_hash' => Hash::make( 'user1'.'developer'.date('Y-m-d H:i:s') ),
        ]);

        Users::create([ 
            'name' => 'user 2',
            'username' => 'user2',
            'password' =>  Hash::make('user2'),
            'user_hash' => Hash::make( 'user 2'.'developer'.date('Y-m-d H:i:s') ),
        ]);
        Users::create([ 
            'name' => 'user 3',
            'username' => 'user3',
            'password' =>  Hash::make('user3'),
            'user_hash' => Hash::make( 'user3'.'developer'.date('Y-m-d H:i:s') ),
        ]);
        Users::create([ 
            'name' => 'user 4',
            'username' => 'user4',
            'password' =>  Hash::make('user4'),
            'user_hash' => Hash::make( 'user4'.'developer'.date('Y-m-d H:i:s') ),
        ]);
        Users::create([ 
            'name' => 'user5',
            'username' => 'user5',
            'password' =>  Hash::make('user5'),
            'user_hash' => Hash::make( 'user5'.'developer'.date('Y-m-d H:i:s') ),
        ]);
        Users::create([ 
            'name' => 'user5',
            'username' => 'user5',
            'password' =>  Hash::make('user5'),
            'user_hash' => Hash::make( 'user5'.'developer'.date('Y-m-d H:i:s') ),
        ]);
        Users::create([ 
            'name' => 'user6',
            'username' => 'user6',
            'password' =>  Hash::make('user6'),
            'user_hash' => Hash::make( 'user6'.'developer'.date('Y-m-d H:i:s') ),
        ]);
        Users::create([ 
            'name' => 'user7',
            'username' => 'user7',
            'password' =>  Hash::make('user7'),
            'user_hash' => Hash::make( 'user7'.'developer'.date('Y-m-d H:i:s') ),
        ]);
        Users::create([ 
            'name' => 'user8',
            'username' => 'user8',
            'password' =>  Hash::make('user8'),
            'user_hash' => Hash::make( 'user8'.'developer'.date('Y-m-d H:i:s') ),
        ]);
        Users::create([ 
            'name' => 'user9',
            'username' => 'user9',
            'password' =>  Hash::make('user9'),
            'user_hash' => Hash::make( 'user9'.'developer'.date('Y-m-d H:i:s') ),
        ]);
        Users::create([ 
            'name' => 'user10',
            'username' => 'user10',
            'password' =>  Hash::make('user10'),
            'user_hash' => Hash::make( 'user10'.'developer'.date('Y-m-d H:i:s') ),
        ]);
        
        Users::create([ 
            'name' => 'user11',
            'username' => 'user11',
            'password' =>  Hash::make('user11'),
            'user_hash' => Hash::make( 'user11'.'developer'.date('Y-m-d H:i:s') ),
        ]);
        
        Users::create([ 
            'name' => 'user12',
            'username' => 'user12',
            'password' =>  Hash::make('user12'),
            'user_hash' => Hash::make( 'user12'.'developer'.date('Y-m-d H:i:s') ),
        ]);
        
        Users::create([ 
            'name' => 'user13',
            'username' => 'user13',
            'password' =>  Hash::make('user13'),
            'user_hash' => Hash::make( 'user13'.'developer'.date('Y-m-d H:i:s') ),
        ]);
        
        Users::create([ 
            'name' => 'user14',
            'username' => 'user14',
            'password' =>  Hash::make('user14'),
            'user_hash' => Hash::make( 'user14'.'developer'.date('Y-m-d H:i:s') ),
        ]);
        
        Users::create([ 
            'name' => 'user15',
            'username' => 'user15',
            'password' =>  Hash::make('user15'),
            'user_hash' => Hash::make( 'user15'.'developer'.date('Y-m-d H:i:s') ),
        ]);
        


    }
}
