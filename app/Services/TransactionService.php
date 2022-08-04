<?php

namespace App\Services;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Maya\MayaCheckout;

use App\Services\CartService;

use App\Models\Transactions;
use App\Models\TransactionLogs;

class TransactionService
{

    public function __construct(CartService $cartService, MayaCheckout $mayaCheckout)
    {
        $this->cartService = $cartService;
        $this->mayaCheckout = $mayaCheckout;
    }

    public function store($request)
    {
        $transaction = new Transactions;

        $transaction->users_id = Auth::user()->id;
        $transaction->code = rand(1000000000, 9999999999);
        $transaction->hash = Hash::make(date('Y-m-d H:i:s'));
        $transaction->date_purchased = date('Y-m-d H:i:s');
        $transaction->total_amount = $request->total_amount;
        $transaction->total_items = $request->total_items;

        $transaction->save();

        $this->storeTransactionLogs($transaction->id, $request->products);

        $this->cartService->remove_items((object) $request->products);

        // return $this->mayaCheckout->checkout($transaction, $request);

        return [
            'code' => $transaction->code,
            'hash' => $transaction->hash,
        ];
    }


    protected function storeTransactionLogs($transaction_id, $product_list)
    {
        TransactionLogs::insert(self::prepIntert($transaction_id, $product_list));
    }

    protected function prepIntert($transaction_id, $product_list)
    {
        $temp_array = [];

        foreach ($product_list as $value) {
            array_push(
                $temp_array,
                [
                    'transaction_id' => $transaction_id,
                    'product_id' => $value['product_id'],
                    'qty' => $value['qty'],
                    'price' => $value['price'],
                    'total_price' => $value['price'] * $value['qty'],
                ]
            );
        }

        return $temp_array;
    }

    public function update_payment($request)
    {
        $transaction = Transactions::where('hash', $request->hash)
            ->where('payment_status', 'pending')
            ->firstOrFail();

        $transaction->payment_status = $request->status;

        $transaction->save();
    }
}
