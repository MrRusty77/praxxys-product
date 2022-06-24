<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
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

		$product = Product::get( $data );

		$product->select( 
			'p.code',
			'p.name',
			'p.description',
			'p.img_path',
			'p.date_and_time',
			'c.id as category_id',
			'c.name as category',
		);

        if( isset( $data['keyword'] ) )
		{
            $product->where( function( $query ) use ( $keyword ) {
                $query->orWhere('p.name', 'LIKE', "%$keyword%")
                    ->orWhere('p.code', 'LIKE', "%$keyword%");
            });
		}

        return $product->paginate(10);
        // return $users->get();
			
    }



    public function uploadImg( Request $request )
    {
		$request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        $imageName = time().'.'.$request->image->extension();  
  
		$file_name = time().'_'.$request->image->getClientOriginalName();
		$file_path = $request->file('image')->storeAs('uploads', $file_name, 'public');

        $request->image->move(public_path('images'), $imageName);
  
		return response()->json( [ 'image_path' => $imageName ], 200 );
	}
    public function AddOrUpdate( Request $data )
    {

        $val = self::validateInput( $data->all() );

        if( !isset( $val['error'] ) )  
            return response()->json( (array) $val, 401 );

        if( isset( $data['hash'] ) == 0 )
            return response()->json( Product::updateProduct( $data->all() ) );
        else
            return response()->json( Product::addProduct( $data->all() ) );
         

    }

    public static function validateInput( $data )
	{

		$messages = [
			'name.required'	=> 'Please Enter Product Name!',
			'code.required'	=> 'Please Enter Code!',
			'category_id.required'	=> 'Please Select Category!',
			'description.required'	=> 'Please Enter Description!',
			'img_path.required'	=> 'Please Enter Image!',
			'date_and_time.required'	=> 'Please Pick Date and Time!',
		];

		$validate_data =  [
			'name'	=> 'required|regex:/[a-zA-Z0-9\s]+/|min:2|max:255',
			'code'	=> 'required|numeric|min:2|max:255',
			'category_id'	=> 'required|numeric|min:2|max:255',
			'description'	=> 'required|regex:/[a-zA-Z0-9\s]+/|min:2',
			'img_path'	=> 'required',
			'date_and_time'	=> 'required',
		];

		$validator = Validator::make( $data, $validate_data, $messages );

		if( $validator->fails() ) 
			return $validator->validate();
		else 
			return true;
		
	}

	public static function removeProduct( Request $data )
	{
        $val = self::validateRemoveProductInput( $data->all() );

        if( !isset( $val['error'] ) )  
            return Product::removeProduct( $data->all() );	
        else 
            response()->json( (array) $val, 404 );

	}

	public static function validateRemoveProductInput( $data )
	{
		$validator = Validator::make( $data, ['hash' => 'required'], ['hash.required' => 'Please select cathegory'] );

		if( $validator->fails() ) {
			return $validator->validate();
		} else {
			return true;
		}
	}
}
