<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Users;
use App\Models\Product;
use App\Models\Categories;
use App\Models\Cart;
use App\Models\Transactions;

class DashboardController extends Controller
{
    public static function index()
    {
        $totalNo = [
            'users' => Users::where('status', '=', 'active')->get()->count(),
            'product' => Product::where('status', '=', 'active')->get()->count(),
            'categories' => Categories::where('status', '=', 'active')->get()->count(),
            'cart' => Cart::where('users_id', auth()->user()->id)->where('status', '=', 'active')->get()->count(),
            'transaction' => Transactions::where('users_id', auth()->user()->id)->where('status', '!=', 'delete')->get()->count(),
        ];

        return Inertia::render('Dashboard', $totalNo);
    }
}
