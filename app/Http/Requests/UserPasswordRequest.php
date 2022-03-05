<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
//        "passwordbaru" => "admin"
//  "passwordlama" => "admin"

        return [
            'passwordlama'       => 'required|max:50|min:3',
            'passwordbaru'       => 'required|max:50|min:3',
        ];
    }

    public function messages()
    {
        return [
            'passwordlama.required'  => 'Kata sandi saat ini harus ada',
            'passwordlama.max'  => 'Kata sandi saat ini maksimal :max karakter',
            'passwordlama.min'  => 'Kata sandi saat ini minimal :min karakter',

            'passwordbaru.required'  => 'Kata sandi baru harus ada',
            'passwordbaru.max'  => 'Kata sandi baru maksimal :max karakter',
            'passwordbaru.min'  => 'Kata sandi baru minimal :min karakter',
        ];
    }
}
