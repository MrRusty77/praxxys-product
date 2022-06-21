<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

use App\Models\Users;

class UsersController extends Controller
{
    public function search( Request $data )
    {
        $data = $data->all();

		$users = Users::get( $data );

		$users->select( 
			'u.name',
			'u.username',
			'u.created_at',
		);

        if( isset( $data['keyword'] ) )
		{
            $users->where( function( $query ) use ( $keyword ) {
                $query->orWhere('u.name', 'LIKE', "%$keyword%")
                    ->orWhere('u.username', 'LIKE', "%$keyword%");
            });
		}

        return $users->paginate(10);
        // return $users->get();
			
    }

    public function createdDev(  ) 
    {
        $users = new Users();

        $users->name			= "John";
        $users->username		= "Dev";
        $users->password	    = Hash::make( "developer" );
        $users->status			= "active";

        $users->save();

        dd( $users );
    }

    public function AddOrUpdate( Request $data )
    {

        $val = self::validateInput( $data->all() );

        if( !isset( $val['error'] ) )  
            return response()->json( (array) $val, 401 );


        if( isset( $data['user_hash'] ) )
            return response()->json( Users::updateUser( $data->all() ) );
        else
            return response()->json( Users::addUser( $data->all() ) );
         

    }

    public static function validateInput( $data )
	{

		$messages = [
			'username.required'		=> 'Please Enter First Name!',
			'name.required'		=> 'Please Enter Name!',
		];


		$validate_data =  [
			'username'	=> 'required|alpha|min:2|max:255',
			'name'	=> 'required|alpha|min:2|max:255',
		];
		
        $messages['password.required']	= 'Please Enter Password!';
        $messages['password.same']		= 'Password does not match';
        $messages['password.min']		= 'Password must be at least 8 charaters!';

        $messages['conf_password.required']	= 'Please Enter Confirmation Password!';
        $messages['conf_password.same']		= 'Password does not match!';

        $validate_data['password']		= 'required|same:conf_password|min:8|max:255';
        $validate_data['conf_password']	= 'required|same:password|min:8|max:255';

		$validator = Validator::make( $data, $validate_data, $messages );

		if( $validator->fails() ) {
			return $validator->validate();
		} else {
			return true;
		}

	}

}

