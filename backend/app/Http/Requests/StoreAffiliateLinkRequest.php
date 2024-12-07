<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAffiliateLinkRequest extends FormRequest
{
    public function rules()
    {
        return [
            'platform' => 'required|string|in:Chaturbate,MyFreeCams,Cam4,Camsoda,Stripchat,Bongacams',
            'url' => 'required|string',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
