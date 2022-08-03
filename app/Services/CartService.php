<?php

namespace App\Services;

use App\Models\Cart;

use Illuminate\Support\Facades\Auth;

class CartService {

    public function CheckInCart($request, Cart $cart)
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
        try {
            $cart = new Cart;
            $cart->users_id = Auth::user()->id;
            $cart->product_id = $request->product_id;
            $cart->qty = $request->qty;
            $cart->save();

            return [
                'message' => 'Product has been added to cart'
            ];
        }  catch (Exception $e) {
            report($e);
    
            return false;
        }
        
    }

    /**
     * Update quantiy the specified product in cart.
     *
     * @param  \App\Models\Cart  $cart
     */
    public function updateProductQuantity($request, $inCart)
    {
        try {
            $cart = Cart::find($inCart->id);

            if ($request->type === 'adding') {
                $cart->qty += $request->qty;
            } else {
                $cart->qty = $request->qty;
            }
            $cart->save();

            return response()->json([
                'message' => 'Product quantity has been added',
            ], 200);
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json([
                'message' => 'Unable to update product quantity',
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy($request, $return_nothing = false)
    {
        try {

            $cart = Cart::find($request->id);

            $cart->status = 'delete';
            $cart->save();

            if($return_nothing){
                return response()->json([
                    'message' => 'Succesfully removed ' . $request->product['name'],
                ], 200);
            }
        } catch (\Illuminate\Database\QueryException $exception) {
            response()->json([
                'message' => 'Unable to removed ' . $request->product['name'],
            ], 400);
        }
    }

    public function remove_items($products)
    {
        foreach ($products as $product) {
            $this->destroy( (object) $product);
        }

    }


}