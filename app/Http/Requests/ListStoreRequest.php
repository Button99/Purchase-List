<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListStoreRequest extends FormRequest
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
            'name' => ['required', 'min:2', 'max: 100'],
            'tag' => ['required', 'min:2', 'max:100'],
            'public' => ['required', 'boolean']
        ];
    }
}
