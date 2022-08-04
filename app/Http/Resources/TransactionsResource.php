<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionsResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'transcation_id' => $this->id,
            'code' => $this->code,
            'date_purchased' => $this->date_purchased,
            'payment_status' => $this->payment_status,
            'total_amount' => $this->total_amount,
            'total_items' => $this->total_items,
            // 'transaction_logs' =>   !is_null($this->transaction_logs) ? TransactionLogsResource::collection($this->transaction_logs) : [],
            'transaction_logs' =>  $this->when(!is_null($this->transaction_logs), TransactionLogsResource::collection($this->transaction_logs)),
        ];
    }
}
