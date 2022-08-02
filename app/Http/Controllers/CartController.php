<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\DestroyCartRequest;
use GuzzleHttp\Psr7\Response;

use Illuminate\Http\Request;
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
    public function updateCart(StoreCartRequest $request, Cart $cart )
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
                ->where('users_id', Auth::user()->id)
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $request->validate([
            'id' => ['required', 'min:1'],
            'status' => ['required'],
        ]);

        try {

            $cart = Cart::find($request->id);

            $cart->status = 'delete';
            $cart->save();

            return response()->json( [
                'message' => 'Succesfully removed ' . $request->product['name'],
            ], 200);

        } 
        catch (\Illuminate\Database\QueryException $exception) 
        {
            response()->json([
                'message' => 'Unable to removed ' . $request->product['name'],
            ], 400);
        }


        
    }
}
