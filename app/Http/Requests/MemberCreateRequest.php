<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberCreateRequest extends FormRequest
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
        return [
            'kode'       => 'required|max:11|min:3|unique:member',
            'nama'       => 'required|max:200|min:3',
            'alamat'       => 'max:200',
            'gsm'       => 'max:20',
            'level'       => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'kode.required'  => 'Kode member harus ada',
            'kode.max'  => 'Kode member maksimal :max karakter',
            'kode.min'  => 'Kode member minimal :min karakter',
            'kode.unique'  => 'Kode member sudah terdaftar di database',

            'nama.required'  => 'Nama lengkap member harus ada',
            'nama.max'  => 'Nama lengkap member maksimal :max karakter',
            'nama.min'  => 'Nama lengkap member minimal :min karakter',

            'alamat.max'  => 'Alamat maksimal :max karakter',
            'gsm.max'  => 'No. HP maksimal :max karakter',

            'level.required'  => 'Level harga harus ada',
            'level.numeric'  => 'Level harga tidak valid',
        ];
    }
}
