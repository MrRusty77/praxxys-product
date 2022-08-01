<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\DestroyCartRequest;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
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

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Http\Requests\StoreCartRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function UpdateCart(StoreCartRequest $request, Cart $cart )
    {

        $inCart = $this->CheckInCart($request, $cart);
        
        if($inCart->count() === 0)
        {
            $this->create( $request );
        } 
        else 
        {
            return $this->updateProductQuantity($request, $inCart->first());
        }


    }

    protected function CheckInCart($request, Cart $cart)
    { 
        return $cart::where('product_id', $request->product_id)
                ->where('user_id', Auth::user()->id)
                ->where('status', 'active');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCartRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function create($request)
    {
        $cart = new Cart;
        $cart->user_id = Auth::user()->id;
        $cart->product_id = $request->product_id;
        $cart->qty = $request->qty;
        $cart->save();

        return $cart;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        return $cart->where('user_id',  Auth::user()->id)->paginate(20);   
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
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Cart  $cart
     */
    public function updateProductQuantity($request, $inCart)
    {
        $cart = Cart::find( $inCart->id );

        if( $request->type === 'adding' )
        {
            $cart->qty += $request->qty;
        }
        else 
        {
            $cart->qty = $request->qty;

        }
        return $cart->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyCartRequest $request)
    {
        $cart = Cart::find($request->cart_id);

        $cart->status = 'delete';

        return $cart->save();
    }
}
