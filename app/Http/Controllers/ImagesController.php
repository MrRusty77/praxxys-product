<?php

namespace App\Http\Controllers;

use App\Models\Images;
use Illuminate\Http\Request;

class ImagesController extends Controller
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

    public function get( Request $data )
    {
        $data = $data->all();

		$images = Images::get( $data );

		$images->select( 
			'i.id as image_id',
			'i.path',
			'i.status',
        );

        return $images->where( 'i.status', '=', 'active' )->get();
			
    }
}
