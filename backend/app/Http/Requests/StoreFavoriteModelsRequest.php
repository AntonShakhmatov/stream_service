<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFavoriteModelsRequest extends FormRequest
{
    public function rules()
    {
        return [
            'username' => 'required|string',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
