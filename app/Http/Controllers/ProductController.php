<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Images;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

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
			'p.id as product_id',
			'p.code',
			'p.name',
			'p.hash',
			'p.description',
			'p.date_and_time',
			'c.id as category_id',
			'c.name as category',
		);

        if( isset( $data['keyword'] ) )
		{
			$keyword = $data['keyword'];

            $product->where( function( $query ) use ( $keyword ) {
                $query->orWhere('p.name', 'LIKE', "%$keyword%")
                    ->orWhere('p.code', 'LIKE', "%$keyword%");
            });
		}

        return $product->paginate(10);
			
    }

    public function uploadImg( Request $request )
    {

		$validate_data = ['image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'];

		$messages = [
			'image.required'	=> 'Please Upload Product image!',
			'image.image'		=> 'Invalid file!',
			'image.mimes'		=> 'Invalid file!',
			'image.max'			=> 'Image filesize must not be more than 2048'
		];

		$messages = [
			'name.required'	=> 'Please Enter Product Name!',
			'code.required'	=> 'Please Enter Code!',
			'category_id.required'	=> 'Please Select Category!',
			'description.required'	=> 'Please Enter Description!',
			'img_path.required'	=> 'Please Enter Image!',
			'date_and_time.required'	=> 'Please Pick Date and Time!',
		];

		$validator = Validator::make( $request->all(), $validate_data, $messages );

		if( $validator->fails() )
			return $validator->validate();

		$request->validate( $validate_data, $messages );
    
        $imageName = time().'.'.$request->image->extension();  
  
		$file_name = time().'_'.$request->image->getClientOriginalName();
		$file_path = $request->file('image')->storeAs('uploads', $file_name, 'public');

        $request->image->move(public_path('images'), $imageName);
  
		return response()->json( [ 'image_path' => $imageName ], 200 );
	}

    public function AddOrUpdate( Request $data )
    {
		$data = (array) $data->all();
        $val = self::validateInput( $data );

        if( isset( $val['error'] ) )  
            return response()->json( (array) $val, 401 );

        if( isset( $data['hash'] ) ){
			$results = Product::updateProduct( $data );
			self::bulkUpdateImages( $data );

            return response()->json( $results );
		}
        else{
			$results = Product::createProduct( $data );

			Images::createImagesBulk( $data['images'], $results['data'] );
            return response()->json( $results );

		}
         

    }

	public static function bulkUpdateImages( $product )
	{
		$results = null;

		foreach ( $product['images'] as $key => $value) 
		{	
			
			if( isset( $value['image_id'] ) )
				$status = Images::updateImages( $value, $product );
			else
				$status = Images::createImages( $value['path'], $product );

			if( is_null( $results ) )
				$results = $status;
		}

		return $results;
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
			'code'	=> 'required|numeric|digits_between:8,8',
			'category_id'	=> 'required|numeric|min:1|max:255',
			'description'	=> 'required|regex:/[a-zA-Z0-9\s]+/|min:2',
			'images.*'	=> 'required',
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
