<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoomRequest extends FormRequest
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
            'username' => ['required', 'string'],
            'age' => ['nullable'],
            'gender' => ['required'],
            'location' => ['required'],
            'language' => ['required'],
            'ethnicity' => ['nullable'],
            'viewers' => ['nullable'],
            'previewImage' => ['nullable'],
            'chatUrl' => ['nullable'],
            'new' => ['nullable'],
            'hd' => ['nullable'],
            'dmca' => ['nullable'],
            'subject' => ['nullable'],
            'height' => ['nullable'],
            'weight' => ['nullable'],
            'bodyType' => ['nullable'],
            'bustPenisSize' => ['nullable'],
            'hairColor' => ['nullable'],
            'hairLength' => ['nullable'],
            'sexOrientation' => ['nullable'],
            'pubicHair' => ['nullable'],
            'eyeColor' => ['nullable'],
            'tags' => ['nullable', 'array'],
        ];
    }
}
