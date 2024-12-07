<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRoomTopicsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'topics' => ['required','bool'],
            'offline' => ['required','bool'],
            'rooms' => ['required', array(
                'chaturbate' => ['required', 'max:5', 'regex:(true|false)'],
                'myfreecams' => ['required', 'max:5', 'regex:(true|false)'],
                'bongacams' => ['required', 'max:5', 'regex:(true|false)'],
                'camsoda' => ['required', 'max:5', 'regex:(true|false)'],
                'cam4' => ['required', 'max:5', 'regex:(true|false)'],
            )],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
