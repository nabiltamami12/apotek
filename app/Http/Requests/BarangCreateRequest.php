<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BarangCreateRequest extends FormRequest
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
            'kode'       => 'required|max:7|min:3|unique:barang',
            'barcode'       => 'required|min:1|max:20|unique:barang',
            'nama'       => 'required|max:100|min:3|unique:barang',
            'jenis'       => 'required|numeric|exists:jenis,id',
            'harga_beli'       => 'required|numeric|min:1',
            'pembulatan'       => 'required|numeric',
            'markup_1'       => 'required|numeric',
            'harga_jual_1'       => 'required|numeric|min:1',
            'markup_2'       => 'required|numeric',
            'harga_jual_2'       => 'required|numeric|min:1'
        ];
    }

    public function messages()
    {
        return [
            'kode.required'  => 'Kode barang harus ada',
            'kode.max'  => 'Kode barang maksimal :max karakter',
            'kode.min'  => 'Kode barang minimal :min karakter',
            'kode.unique'  => 'Kode barang sudah terdaftar di database',

            'barcode.required'  => 'Kode barcode barang harus ada',
            'barcode.max'  => 'Kode barcode barang maksimal :max karakter',
            'barcode.min'  => 'Kode barcode barang minimal :min karakter',
            'barcode.unique'  => 'Kode barcode barang sudah terdaftar di database',

            'nama.required'  => 'Nama barang harus ada',
            'nama.max'  => 'Nama barang maksimal :max karakter',
            'nama.min'  => 'Nama barang minimal :min karakter',
            'nama.unique'  => 'Nama barang sudah terdaftar di database',

            'jenis.required'  => 'Jenis barang harus ada',
            'jenis.numeric'  => 'ID jenis barang harus berupa angka',
            'jenis.exists'  => 'Jenis barang tidak terdaftar di database',

            'harga_beli.required'  => 'Harga beli harus ada',
            'harga_beli.numeric'  => 'Harga beli harus berupa angka',
            'harga_beli.min'  => 'Harga beli minimal :min',

            'pembulatan.required'  => 'Nilai pembulatan harus ada',
            'pembulatan.numeric'  => 'Nilai pembulatan harus berupa angka',

            'markup_1.required'  => 'Nilai markup harga 1 harus ada',
            'markup_1.numeric'  => 'Nilai markup harga 1 harus berupa angka',

            'harga_jual_1.required'  => 'Harga jual 1 harus ada',
            'harga_jual_1.numeric'  => 'Harga jual 1 harus berupa angka',
            'harga_jual_1.min'  => 'Harga jual 1 minimal :min',

            'markup_2.required'  => 'Nilai markup harga 2 harus ada',
            'markup_2.numeric'  => 'Nilai markup harga 2 harus berupa angka',

            'harga_jual_2.required'  => 'Harga jual 2 harus ada',
            'harga_jual_2.numeric'  => 'Harga jual 2 harus berupa angka',
            'harga_jual_2.min'  => 'Harga jual 2 minimal :min',
            
        ];
    }
}
