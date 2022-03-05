<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'username'       => 'required|max:50|min:3',
            'role'       => 'required|numeric|exists:roles,id',
            'fullname'       => 'required|max:200|min:3',
            'active'      => 'required|in:1,0',
        ];
    }

    public function messages()
    {
        return [
            'username.required'  => 'Username harus ada',
            'username.max'  => 'Username maksimal :max karakter',
            'username.min'  => 'Username minimal :min karakter',

            'role.required'  => 'Grup user harus ada',
            'role.numeric'  => 'Grup user tidak valid',
            'role.exists'  => 'Grup user tidak terdaftar di database',

            'fullname.required'  => 'Nama lengkap user harus ada',
            'fullname.max'  => 'Nama lengkap user maksimal :max karakter',
            'fullname.min'  => 'Nama lengkap user minimal :min karakter',

            'active.required'  => 'Status aktif harus ada',
            'active.in'  => 'Status aktif harus bernilai True atau False',
        ];
    }
}
