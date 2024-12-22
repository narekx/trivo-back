<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "description" => $this->description,
            "sku" => $this->sku,
            "price" => $this->price,
            "category" => $this->whenLoaded("category", fn() => new CategoryResource($this->category)),
            "createdAt" => $this->whenHas("created_at", fn() => $this->created_at_formatted),
            "updatedAt" => $this->whenHas("updated_at", fn() => $this->updated_at_formatted),
        ];
    }
}
