<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'title'       => ['sometimes','string','max:255'],
            'description' => ['sometimes','string'],
            'image'       => ['sometimes','url','max:2048'],
            'price'       => ['sometimes','numeric','min:0'],
        ];
    }
}
