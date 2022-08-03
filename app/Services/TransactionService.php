<?php

namespace App\Services;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Services\CartService;

use App\Models\Transactions;
use App\Models\TransactionLogs;

class TransactionService {

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function store($request)
    {
        $transaction = new Transactions;

        $transaction->users_id = Auth::user()->id;
        $transaction->code = Hash::make(date('Y-m-d H:i:s'));
        $transaction->total_amount = $request->total_amount;
        $transaction->total_items = $request->total_items;

        $transaction->save();

        $this->storeTransactionLogs($transaction->id, $request->products);

        $this->cartService->remove_items((object) $request->products);

        return $transaction->code;
    }


    protected function storeTransactionLogs($transactions_id, $product_list)
    {
        TransactionLogs::create(self::prepIntert($transactions_id, $product_list));
    }

    protected function prepIntert($transactions_id, $product_list)
    {
        $temp_array = [];

        foreach ($product_list as $value) {
            $temp_array['transaction_id'] = $transactions_id;
            $temp_array['product_id'] = $value['product']['id'];
            $temp_array['qty'] = $value['qty'];
            $temp_array['price'] = $value['product']['price'];
            $temp_array['total_price'] = $value['product']['price'] * $value['qty'];
        }

        return $temp_array;
    }

    public function update_payment($request)
    {
        $transaction = Transactions::where('code', $request->code)
            ->where('payment_status', 'pending')
            ->firstOrFail();

        $transaction->payment_status = $request->status;

        $transaction->save();
    }

}