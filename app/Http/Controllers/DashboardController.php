<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Users;
use App\Models\Product;
use App\Models\Categories;

class DashboardController extends Controller
{
    public static function getNumbers( Request $request )
    {
        $totalNo = [
            'users' => Users::where('status', '=', 'active')->get()->count(),
            'product' => Product::where('status', '=', 'active')->get()->count(),
            'categories' => Categories::where('status', '=', 'active')->get()->count(),
        ]; 

        return $totalNo;
    }
}
