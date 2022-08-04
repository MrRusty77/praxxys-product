<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TransactionLogsResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [
            "transaction_log_id"    => $this->id,
            "price"                 => $this->price,
            "qty"                   => $this->qty,
            "total_price"           => $this->total_price,
            "total_price"           => $this->total_price,
            // "product_id"            => $this->product->id,
            // "code"                  => $this->product->code,
            // "date_and_time"         => $this->product->date_and_time,
            // "description"           => $this->product->description,
            // "hash"                  => $this->product->hash,
            // "name"                  => $this->product->name,
            // "images"                => ImagesResource::collection($this->product->images),
        ];
    }
}
