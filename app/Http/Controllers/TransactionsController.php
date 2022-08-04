<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Http\Requests\StoreTransactionsRequest;
use App\Http\Requests\UpdateTransactionsRequest;
use App\Http\Requests\MayaRequest;

use App\Services\CartService;
use App\Services\TransactionService;

use App\Http\Resources\TransactionsResource;

use App\Models\Transactions;

class TransactionsController extends Controller
{

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(CartService $cartService, TransactionService $transactionService)
    {
        $this->cartService = $cartService;
        $this->transactionService = $transactionService;
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
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTransactionsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTransactionsRequest $request)
    {
        return $this->transactionService->store($request);
    }

    public function mayaPayment(MayaRequest $request)
    {
        $this->transactionService->update_payment($request);

        return view("paymentMessage", ['status' => $request->status, 'code' => $request->code]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transactions  $transactions
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $transactions = Transactions::where('users_id', Auth::user()->id)
            ->where('transactions.status', '!=', 'delete')
            ->with('transactionLogs.product.images')
            ->orderBy('transactions.date_purchased', 'DESC');

        $transactions->when(isset($request->keyword), function ($query) use ($request) {

            $keyword = $request->keyword;

            return $query->where(function ($query) use ($keyword) {
                $query->orWhere('transactions.code', 'LIKE', "%$keyword%");
                // ->orWhere('product.code', 'LIKE', "%$keyword%");``
            });;
        });


        return ($transactions->paginate(20));
        // $transactions = Transactions::with('transactionLogs')->get();

        // return TransactionsResource::collection($transactions);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transactions  $transactions
     * @return \Illuminate\Http\Response
     */
    public function edit(Transactions $transactions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTransactionsRequest  $request
     * @param  \App\Models\Transactions  $transactions
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTransactionsRequest $request, Transactions $transactions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transactions  $transactions
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transactions $transactions)
    {
        //
    }
}
