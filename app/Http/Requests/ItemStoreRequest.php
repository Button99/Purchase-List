<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(auth()->user()) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'max:50', 'min: 2'],
            'description' => ['required', 'max:600'],
            'link' => ['required', 'url'],
            'price' => ['required', 'numeric'],
            'lists' => ['required', 'integer'],
            'hasBeenBought' => ['required', 'boolean'],
            'image' => ['image', 'mimes:jpg,jpeg,png', 'max:2048']
        ];
    }
}
