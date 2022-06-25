<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Images extends Model
{
    use HasFactory;

    public function get( $data = null )
    {

        $images = DB::table('images as i');

        if( !isset( $data['status'] ) )
            $images->where( 'i.status', '=', 'active' );
        else
            $images->where( 'i.status', '=', $data['status'] );
        
        if( isset( $data['product_id'] ) )
            $images->where( 'i.product_id', '=', $data['product_id'] );

        // if( isset( $data['hash'] ) )
        //     $images->where( 'i.product_hash', '=', $data['hash'] );
		
        return $images;
    }

    public static function createImages( $image_path, $product ) {
        $images = new Images();
        
        $images->path           = $image_path;
        $images->product_id     = $product['product_id'];
        $images->product_hash   = $product['hash'];

        $images->save();

        return [ 
            "error" => null,
        ];
    }

    public static function createImagesBulk( $images, $product ) {
        $query = [];
		
        foreach ( $images as $key => $value ) 
		{
			$value = (array) $value;

			array_push( $query, [ 
				'path'				    => $value['path'],
				'product_id'		    => $product['product_id'],
				'product_hash'			=> $product['hash'],
			] );
		}

        Images::insert( $query );

        return [ 
            "error" => null,
        ];
    }

    public static function updateImages( $image, $product )
	{
		try
		{
            $new_update = [
				"path"		    => $image['path'],
                "product_id"	=> $product['product_id'],
				"product_hash"	=> $product['hash'],
			];

			$images = Images::where( 'id', '=' , $image['image_id'] );

			if( isset( $image['status'] ) )
				$new_update["status"]	= $image['status'];

			$images->update( $new_update );

			return [ 
				"error" => null
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

	public static function removeImages( $data )
	{
		try
		{
			$users = Images::where( 'id', '=' , $data['category_id'] );
			
			$users->update( [ 'status' => 'delete' ] );

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
