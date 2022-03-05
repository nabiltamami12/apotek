<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuplierCreateRequest extends FormRequest
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
            'kode'       => 'required|max:11|min:3|unique:suplier',
            'nama'       => 'required|max:200|min:3',
            'alamat'       => 'max:200',
            'telp'       => 'max:20',
            'bank'       => 'required|max:200',
            'norek'       => 'required|max:20|min:3',
            'bank_pemilik'       => 'required|max:250|min:3',
            'email'       => 'max:250',
        ];
    }

    public function messages()
    {
        return [
            'kode.required'  => 'Kode suplier harus ada',
            'kode.max'  => 'Kode suplier maksimal :max karakter',
            'kode.min'  => 'Kode suplier minimal :min karakter',
            'kode.unique'  => 'Kode suplier sudah terdaftar di database',

            'nama.required'  => 'Nama suplier harus ada',
            'nama.max'  => 'Nama lengkap suplier maksimal :max karakter',
            'nama.min'  => 'Nama lengkap suplier minimal :min karakter',

            'alamat.max'  => 'Alamat maksimal :max karakter',
            'telp.max'  => 'No. Telp maksimal :max karakter',
			
			'bank.required'  => 'Nama Bank suplier harus ada',
            'bank.max'  => 'Nama Bank suplier maksimal :max karakter',
            'bank.min'  => 'Nama Bank suplier minimal :min karakter',
			
			'norek.required'  => 'Norek Bank suplier harus ada',
            'norek.max'  => 'Norek Bank suplier maksimal :max karakter',
            'norek.min'  => 'Norek Bank suplier minimal :min karakter',
			
			'bank_pemilik.required'  => 'Nama Pemilik Rek Bank suplier harus ada',
            'bank_pemilik.max'  => 'Nama Pemilik Rek maksimal :max karakter',
            'bank_pemilik.min'  => 'Nama Pemilik Rek minimal :min karakter',

        ];
    }
}
