<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

use Illuminate\Support\Facades\Auth;

use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\DestroyCartRequest;

use App\Http\Resources\CartResource;

use Illuminate\Http\Request;

use App\Models\Cart;
use App\Services\CartService;

class CartController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Cart', []);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Http\Requests\StoreCartRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function updateCart(StoreCartRequest $request, Cart $cart)
    {

        $cart = $this->cartService->checkInCart($request, $cart);

        if ($cart->count() === 0) {
            return $this->cartService->create($request);
        }

        return $this->cartService->updateProductQuantity($request, $cart->first());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCartRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function add($request)
    {
        // $cart = new Cart;
        // $cart->user_id = Auth::user()->id;
        // $cart->product_id = $request->product_id;
        // $cart->qty = $request->qty;
        // $cart->save();

        // return $cart;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        $users_cart = $cart->where('users_id', Auth::user()->id)
            ->with('product.images')
            ->where('cart.status', 'active')
            ->paginate(20);

        return CartResource::collection($users_cart);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $request->validate([
            'cart_id' => ['required', 'min:1']
        ]);

        return $this->cartService->destroy($request);
    }
}
