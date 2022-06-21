<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Laravel\Sanctum\HasApiTokens;

class Users extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    public function get( $data = null )
    {
        $users = DB::table('users as u');

        if( !isset( $data['status'] ) )
            $users->where( 'u.status', '=', 'active' );
        else
            $users->where( 'u.status', '=', $data['status'] );
        
        if( isset( $data['name'] ) )
            $users->where( 'u.name', '=', $data['name'] );

        if( isset( $data['username'] ) )
            $users->where( 'u.username', '=', $data['username'] );

        return $users;
    }

    public static function createUser($data) {
        $users = new users();

        $users->name			= $data['name'];
        $users->username		= $data['username'];
        $users->user_hash		= Hash::make( $data['password'].$data['username'].$data['name'].date('Y-m-d H:i:s') );
        $users->password		= Hash::make( $data['password'] );
        $users->status			= "active";

        $users->save();

        return [ 
            "error" => null,
            "message" => "Successfully added " . $data['first_name'],
        ];
    }

    public static function updateUser( $data )
	{

		try
		{
			$new_update = [
				"name"		=> $data['name'],
				"username"	=> $data['username'],
			];

			$users = Users::where( 'user_hash', '=' , $data['user_id'] );

			if( isset( $data['status'] ) )
				$new_update["status"]	= $data['status'];

			if( isset( $data['password'] ) )
				$new_update["password"]	= Hash::make( $data['password'] );

			$users->update( $new_update );

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


}
