<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GrupUpdateRequest extends FormRequest
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
            'name'       => 'required|max:100|min:2',
            'display_name'       => 'required|max:200|min:2',
            'permissions_grup'      => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required'  => 'Kolom Nama Grup User harus diisi',
            'name.max'  => 'Kolom Nama Grup User maksimal :max karakter',
            'name.min'  => 'Kolom Nama Grup User minimal :min karakter',

            'display_name.required'  => 'Kolom Nama yang akan terlihat harus diisi',
            'display_name.max'  => 'Kolom Nama yang akan terlihat maksimal :max karakter',
            'display_name.min'  => 'Kolom Nama yang akan terlihat minimal :min karakter',

            'permissions_grup.required' => 'Grup User harus memiliki Hak Akses'
        ];
    }
}
