<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\DestroyCartRequest;
use GuzzleHttp\Psr7\Response;

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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Http\Requests\StoreCartRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function updateCart(StoreCartRequest $request, Cart $cart )
    {

        $inCart =  $this->cartService->CheckInCart($request, $cart);
        
        if($inCart->count() === 0)
        {
            return $this->cartService->create( $request );
        } 
        
        return $this->cartService->updateProductQuantity($request, $inCart->first());
    
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
        $users_cart = Cart::where('users_id', 2)
            ->with('product.images')
            ->where('cart.status', 'active')
            ->paginate(20); 

        return $users_cart;   
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
            'id' => ['required', 'min:1']
        ]);

        return $this->cartService->destroy($request);
 
    }
}
