<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            "createdAt" => $this->whenHas("created_at", fn() => $this->created_at_formatted),
            "updatedAt" => $this->whenHas("updated_at", fn() => $this->updated_at_formatted),
        ];
    }
}
