<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductsResouce extends JsonResource
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
            "product_id"    => $this->id,
            "code"          => $this->code,
            "date_and_time" => $this->date_and_time,
            "description"   => $this->description,
            "hash"          => $this->hash,
            "name"          => $this->name,
            "price"         => $this->price,
            "images"        => ImagesResource::collection($this->images),
        ];
    }
}
