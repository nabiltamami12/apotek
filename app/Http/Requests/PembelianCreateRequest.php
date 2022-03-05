<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PembelianCreateRequest extends FormRequest
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
            'kode'       => 'required|max:11|min:11|unique:pembelian,kode|exists:sementara,kode',
            'tgl'      => 'required|date',
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
            
            'tgl.required'=> 'Tanggal transaksi harus diisi',
            'tgl.date'=> 'Tanggal  transaksi tidak valid',
            
        ];
    }
}
