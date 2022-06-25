<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

        if( isset( $data['product_hash'] ) )
            $images->where( 'i.product_hash', '=', $data['product_hash'] );

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
            "message" => "Successfully added " . $data['name'],
        ];
    }

    public static function createImagesBulk( $image_path, $product ) {
        $query = [];
        
        foreach ( $product as $key => $value ) 
		{
			$value = (array) $value;
			
			array_push( $query, [ 
				'path'				    => $image_path,
				'product_id'		    => $value['product_id'],
				'product_hash'			=> $value['hash'],
				'item_reorder_level'	=> $value['item_reorder_level'],
				'date_created'			=> date('Y-m-d H:i:s'),

			] );
		}


        Images::insert( $query );

        return [ 
            "error" => null,
            "message" => "Successfully added " . $data['name'],
        ];
    }

    public static function updateImages( $image_path, $product )
	{
		try
		{
            $new_update = [
				"path"		    => $image_path,
                "product_id"	=> $product['product_id'],
				"product_hash"	=> $product['hash'],
			];

			$images = Images::where( 'id', '=' , $data['category_id'] );

			if( isset( $data['status'] ) )
				$new_update["status"]	= $data['status'];

			$images->update( $new_update );

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
