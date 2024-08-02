<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BarangStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules():array
    {
        return [
            'nama_barang' => 'required',
            'kode_barang' => 'required',
            'harga'         => 'required|numeric'
        ];
    }
    public function messages()
    {
        return [
            //
            'nama_barang' => 'Nama barang harus diisi',
            'kode_barang.required' => 'Kode barang harus diisi',
            'harga.required' => 'Harga barang harus diisi'
        ];
    }

    public function filters()
    {
        return [
            'nama_barang' => 'trim|capitalize|escape'
        ];
    }
}
