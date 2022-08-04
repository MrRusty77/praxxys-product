<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
            "cart_id"       => $this->id,
            "qty"           => $this->qty,
            "product_id"    => $this->product->id,
            "name"          => $this->product->name,
            "code"          => $this->product->code,
            "price"         => $this->product->price,
            "image_path"    => $this->product->images[0]->path,
        ];
    }
}
