<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class Categories extends Model
{
    use HasFactory;

	public function product()
	{
		return $this->hasMany(Product::class);
	}

    public function get( $data = null )
    {
        $categories = DB::table('categories as c');

        if( !isset( $data['status'] ) )
            $categories->where( 'c.status', '=', 'active' );
        else
            $categories->where( 'c.status', '=', $data['status'] );
        
        if( isset( $data['name'] ) )
            $categories->where( 'c.name', '=', $data['name'] );

        return $categories;
    }

    public static function createCategory($data) {
        $categories = new categories();

        $categories->name = $data['name'];

        $categories->save();

        return [ 
            "error" => null,
            "message" => "Successfully added " . $data['name'],
        ];
    }

    public static function updateCategory( $data )
	{

		try
		{
			$new_update = [
				"name"		=> $data['name'],
			];

			$categories = Categories::where( 'id', '=' , $data['category_id'] );

			if( isset( $data['status'] ) )
				$new_update["status"]	= $data['status'];

			$categories->update( $new_update );

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

	public static function removeCategory( $data )
	{
		try
		{
			$users = Categories::where( 'id', '=' , $data['category_id'] );
			
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
