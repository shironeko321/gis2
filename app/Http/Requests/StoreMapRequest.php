<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMapRequest extends FormRequest
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
        return [
            "latitude" => "required|numeric",
            "longitude" => "required|numeric",
            "name" => "required",
            "description" => "string",
            "category" => "required|exists:categories,id",
            "open" => "string",
            "close" => "string",
            "daily" => "array",
            "image.*" => "image"
        ];
    }
}
