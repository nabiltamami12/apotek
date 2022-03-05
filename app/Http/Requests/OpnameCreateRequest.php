<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OpnameCreateRequest extends FormRequest
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
  //       "kode" => "OP170503222816"
  // "tgl" => "05/03/2017"
  // "barang" => "BA00001"
  // "stok_nyata" => "10"
  // "stok_komputer" => "0"
  // "selisih" => "10"
  // "keterangan" => "Stok Awal"
        return [
            'kode'       => 'required|max:14|min:14|unique:opname',
            'tgl'      => 'required|date',
            'barang'       => 'required|max:7|min:3|exists:barang,kode',
            'stok_nyata'       => 'required|numeric|min:0',
            'stok_komputer'       => 'required|numeric|min:0',
            'selisih'       => 'required|numeric',
            'keterangan'       => 'required|min:1|max:100'
        ];
    }

    public function messages()
    {
        return [
            'kode.required'  => 'No. bukti stok opname harus ada',
            'kode.max'  => 'No. bukti stok opname maksimal :max karakter',
            'kode.min'  => 'No. bukti stok opname minimal :min karakter',
            'kode.unique'  => 'No. bukti stok opname sudah terdaftar di database',

            'tgl.required'  => 'Tanggal stok opname harus ada',
            'tgl.date'  => 'Tanggal stok opname tidak valid',

            'barang.required'  => 'Kode barang harus ada',
            'barang.max'  => 'Kode barnag maksimal :max karakter',
            'barang.min'  => 'Kode barang minimal :min karakter',
            'barang.exists'  => 'Kode barang tidak terdaftar di database',

            'stok_komputer.required'  => 'Stok komputer harus ada',
            'stok_komputer.numeric'  => 'Stok komputer harus berupa angka',
            'stok_komputer.min'  => 'Stok komputer minimal :min',

            'stok_nyata.required'  => 'Stok nyata harus ada',
            'stok_nyata.numeric'  => 'Stok nyata harus berupa angka',
            'stok_nyata.min'  => 'Stok nyata minimal :min',

            'selisih.required'  => 'Nilai selisih harus ada',
            'selisih.numeric'  => 'Nilai selisih harus berupa angka',

            'keterangan.required'  => 'Keterangan stok opname harus ada',
            'keterangan.max'  => 'Keterangan stok opname maksimal :max karakter',
            'keterangan.min'  => 'Keterangan stok opname minimal :min karakter',
            
        ];
    }
}
