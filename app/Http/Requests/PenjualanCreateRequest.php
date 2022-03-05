<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PenjualanCreateRequest extends FormRequest
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
            'kode'       => 'required|max:11|min:11|unique:penjualan,kode|exists:sementara,kode',
            'bayar'=>'required|numeric|min:1'
        ];
    }

    public function messages()
    {
        return [

            'kode.required'  => 'No. Bukti harus ada',
            'kode.max'  => 'No. Bukti maksimal :max karakter',
            'kode.min'  => 'No. Bukti minimal :min karakter',
            'kode.unique'  => 'No. Bukti sudah terdaftar di database',
            'kode.exists'  => 'No. Bukti tidak terdaftar di tabel transaksi',

            'bayar.required'=> 'Jumlah pembayaran harus ada',
            'bayar.numeric'=> 'Jumlah pembayaran harus berupa angka',
            'bayar.min'=> 'Jumlah pembayaran minimal :min',
            
        ];
    }
}
