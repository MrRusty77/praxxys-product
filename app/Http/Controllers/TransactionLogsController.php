<?php

namespace App\Http\Controllers;

use App\Models\TransactionLogs;
use App\Http\Requests\StoreTransactionLogsRequest;
use App\Http\Requests\UpdateTransactionLogsRequest;
use Transactions;

class TransactionLogsController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTransactionLogsRequest  $request
     * @return \Illuminate\Http\Response
     */
    // public static function store($transactions_id, $product_list)
    // {
    //     TransactionLogs::create(self::prepIntert($transactions_id, $product_list));
    // }

    // protected function prepIntert($transactions_id, $product_list)
    // {
    //     $temp_array = [];

    //     foreach ($product_list as $value) {
    //         $temp_array['transaction_id'] = $transactions_id;
    //         $temp_array['product_id'] = $value['product']['id'];
    //         $temp_array['qty'] = $value['qty'];
    //         $temp_array['price'] = $value['product']['price'];
    //         $temp_array['total_price'] = $value['product']['price'] * $value['qty'];
    //     }

    //     return $temp_array;
    // }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TransactionLogs  $transactionLogs
     * @return \Illuminate\Http\Response
     */
    public function show(TransactionLogs $transactionLogs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TransactionLogs  $transactionLogs
     * @return \Illuminate\Http\Response
     */
    public function edit(TransactionLogs $transactionLogs)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTransactionLogsRequest  $request
     * @param  \App\Models\TransactionLogs  $transactionLogs
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTransactionLogsRequest $request, TransactionLogs $transactionLogs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TransactionLogs  $transactionLogs
     * @return \Illuminate\Http\Response
     */
    public function destroy(TransactionLogs $transactionLogs)
    {
        //
    }
}
