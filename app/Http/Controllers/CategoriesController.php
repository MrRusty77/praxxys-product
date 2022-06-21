<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function search( Request $data )
    {
        $data = $data->all();

		$categories = Categories::get( $data );

		$categories->select( 
			'c.id as category_id',
			'c.name',
			'c.created_at',
		);

        if( isset( $data['keyword'] ) )
		{
            $categories->where( function( $query ) use ( $keyword ) {
                $query->orWhere('c.name', 'LIKE', "%$keyword%");
            });
		}

        return $categories->paginate(10);
        // return $users->get();
			
    }

    public function AddOrUpdate( Request $data )
    {

        $val = self::validateInput( $data->all() );

        if( !isset( $val['error'] ) )  
            return response()->json( (array) $val, 401 );

        if( $data['category_id'] == 0 )
            return response()->json( Categories::addCategories( $data->all() ) );
        else
            return response()->json( Categories::updateCategories( $data->all() ) );
         

    }

    public static function validateInput( $data )
	{

		$messages = [
			'name.required'	=> 'Please Enter Category Name!',
		];


		$validate_data =  [
			'name'	=> 'required|alpha|min:2|max:255',
		];

		$validator = Validator::make( $data, $validate_data, $messages );

		if( $validator->fails() ) 
			return $validator->validate();
		else 
			return true;
		
	}
}
