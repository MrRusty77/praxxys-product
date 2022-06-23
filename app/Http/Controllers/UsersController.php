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
			'u.user_hash',
			'u.username',
			'u.created_at',
		);

        if( isset( $data['keyword'] ) )
		{
            $keyword = $data['keyword'];

            $users->where( function( $query ) use ( $keyword ) {
                $query->orWhere('u.name', 'LIKE', "%$keyword%")
                    ->orWhere('u.username', 'LIKE', "%$keyword%");
            });
		}

        return $users
            ->where( 'u.status', '=', 'active' )
            ->paginate(10);
        // return $users->get();
			
    }

    public function createdDev(  ) 
    {
        $users = new Users();

        $users->name			= "John";
        $users->username		= "Dev";
        $users->username		= "Dev";
        $users->password	    = Hash::make( "developer" );
        $users->user_hash	    = Hash::make( "developer" );
        $users->status			= "active";

        $users->save();

        dd( $users );
    }

    public function AddOrUpdate( Request $data )
    {

        $val = self::validateInput( $data->all() );

        if( isset( $val['error'] ) )  
            return response()->json( (array) $val, 401 );

        if( isset( $data['user_hash'] ) )
            return response()->json( Users::updateUser( $data->all() ) );
        else
            return response()->json( Users::createUser( $data->all() ) );
         

    }

    public static function validateInput( $data )
	{

		$messages = [
			'username.required'		=> 'Please Enter First Name!',
			'name.required'		=> 'Please Enter Name!',
		];


		$validate_data =  [
			'username'	=> 'required|alphanum|min:2|max:255',
			'name'	=> 'required|regex:/^[\pL\s\-]+$/u|min:2|max:255',
		];
		
        $messages['password.required']	= 'Please Enter Password!';
        $messages['password.same']		= 'Password does not match';
        $messages['password.min']		= 'Password must be at least 8 charaters!';

        $messages['confirmPassword.required']	= 'Please Enter Confirmation Password!';
        $messages['confirmPassword.same']		= 'Password does not match!';

        $validate_data['password']		= 'required|same:confirmPassword|min:8|max:255';
        $validate_data['confirmPassword']	= 'required|same:password|min:8|max:255';

		$validator = Validator::make( $data, $validate_data, $messages );

		if( $validator->fails() ) {
			return $validator->validate();
		} else {
			return true;
		}

	}

    public static function checkUsername( Request $data  )
	{
		return self::validateUserName( $data->all() );
	}

    public static function validateUserName( $user )
	{
        if( !isset( $user['user_hash'] ) )
            $user['user_hash'] = '';

		$self = (array) Users::get( [ 'user_hash' => $user['user_hash'], 'username' => $user['username'] ] )->select('u.username')->first();

		$username = (array) Users::get( [ 'username' => $user['username'] ] )->select('u.username')->first();

		if( isset( $self['username'] ) && isset( $username['username'] ) )
		{
			
			if( is_null($self) && is_null($username) ) 
				return 'false';
			elseif( is_null($self) && !is_null($username) )
				return 'true';
			elseif( !is_null($self) && is_null($username) )
				return 'false';
			elseif( $self['username'] == $username['username'] )
				return 'false';
			else
				return 'true';
		}
		else
		{
			if( isset( $username['username'] ) )
				return 'true';
			else
				return 'false';
		}
	}

    public static function removeUser( Request $data )
	{
        $val = self::validateRemoveUserInput( $data->all() );

        if( !isset( $val['error'] ) )  
            return Users::removeUser( $data->all() );	
        else 
            response()->json( (array) $val, 404 );

	}

	public static function validateRemoveUserInput( $data )
	{
		$validator = Validator::make( $data, ['user_hash' => 'required'], ['user_hash.required' => 'Please select cathegory'] );

		if( $validator->fails() ) {
			return $validator->validate();
		} else {
			return true;
		}
	}

}

