<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SementaraUpdateRequest extends FormRequest
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
            'qty'       => 'required|numeric|min:1',
            'harga'       => 'required|numeric|min:1',
        ];
    }

    public function messages()
    {
        return [
            'qty.required'  => 'QTY harus ada',
            'qty.numeric'  => 'QTY harus berupa angka',
            'qty.min'  => 'QTY minimal :min',

            'harga.required'  => 'Harga beli harus ada',
            'harga.numeric'  => 'Harga beli harus berupa angka',
            'harga.min'  => 'Harga beli minimal :min',
            
        ];
    }
}
