<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PembelianUpdateRequest extends FormRequest
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
  //       "stok" => "1"
  // "tgl" => "03/22/2017"
  // "kode" => "BA00001"
        return [
            'kode'       => 'required|max:11|min:11|exists:pembelian,kode|exists:sementara,kode',
            'tgl'      => 'required|date',
        ];
    }

    public function messages()
    {
        return [

            'kode.required'  => 'No. Bukti harus ada',
            'kode.max'  => 'No. Bukti maksimal :max karakter',
            'kode.min'  => 'No. Bukti minimal :min karakter',
            'kode.exists'  => 'No. Bukti tidak terdaftar di tabel transaksi',
            
            'tgl.required'=> 'Tanggal pembelian harus diisi',
            'tgl.date'=> 'Tanggal  pembelian harus berupa tanggal',
            
        ];
    }
}
