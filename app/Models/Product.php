<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';

    public function get( $data = null )
    {
        $product = DB::table('product as p')
            ->leftJoin( 'categories as c', 'c.id', '=', 'p.category_id' );

        if( !isset( $data['status'] ) )
            $product->where( 'p.status', '=', 'active' );
        else
            $product->where( 'p.status', '=', $data['status'] );
        
        if( isset( $data['name'] ) )
            $product->where( 'p.name', '=', $data['name'] );

        if( isset( $data['code'] ) )
            $product->where( 'p.code', '=', $data['code'] );

        if( isset( $data['category_id'] ) )
            $product->where( 'p.category_id', '=', $data['category_id'] );

        if( isset( $data['description'] ) )
            $product->where( 'p.description', '=', $data['description'] );

        if( isset( $data['hash'] ) )
            $product->where( 'p.hash', '=', $data['hash'] );

        return $product;
    }

    public static function createProduct($data) {
        $product = new Product();
          
        $product->name		    = $data['name'];
        $product->code		    = $data['code'];
        $product->hash		    = Hash::make( $data['name'].date('Y-m-d H:i:s') );
        $product->category_id	= $data['category_id'];
        $product->img_path	    = $data['img_path'];

        $product->save();

        return [ 
            "error" => null,
            "message" => "Successfully added " . $data['name'],
        ];
    }

    public static function updateUser( $data )
	{

		try
		{
			$new_update = [
				"name"          => $data['name'],
				"category_id"	=> $data['category_id'],
				"description"	=> $data['description'],
				"img_path"      => $data['img_path'],
				"date_and_time"	=> $data['date_and_time'],
			];

			$product = Product::where( 'hash', '=' , $data['hash'] );

			if( isset( $data['status'] ) )
				$new_update["status"]	= $data['status'];

			if( isset( $data['password'] ) )
				$new_update["password"]	= Hash::make( $data['password'] );

			$product->update( $new_update );

			return [ 
				"error" => null,
				"message" => "Successfully updated " . $data['name'],
			];

		}
		catch(Exception $e)
		{
			return [ 
				"error" => [
					"server" => "Unable to save User data, Please try again later"
				],
				"message" => "Server error"
			];

		}

	}

    public static function removeProduct( $data )
	{
		try
		{
			$product = Product::where( 'hash', '=' , $data['hash'] );
			
			$product->update( [ 'status' => 'delete' ] );

			return [ 
				"error" => null,
				"message" => "Successfully remove " . $data['name'],
			];

		}
		catch(Exception $e)
		{
			return [ 
				"error" => [
					"server" => "Unable to save User data, Please try again later"
				],
				"message" => "Server error"
			];

		}

	}
}
