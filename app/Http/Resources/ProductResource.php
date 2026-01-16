<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'price'       => (float) $this->price,
            'description' => $this->description,
            'rating'      => (float) $this->rating,
            'in_stock'    => (bool) $this->in_stock,

            'category'    => new CategoryResource($this->whenLoaded('category')),
            'created_at'  => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
