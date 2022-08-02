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
    public static function store( $transactions_id, $product_list)
    {
        TransactionLogs::create( $this->prepIntert( $transactions_id, $product_list ) );
    }

    protected function prepIntert($transactions_id, $product_list)
    {
        foreach ($product_list as $value) {
            $value['transaction_id'] = $transactions_id;
        }

        return $product_list;
    }

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
