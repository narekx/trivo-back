<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class ProductUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->route("product");

        return [
            'category_id' => 'required|int',
            'name' => 'required|max:255',
            'sku' => "required|min:3|max:6|unique:products,sku,$id",
            'description' => 'required',
            'price' => 'required|int|min:0',
        ];
    }
}
