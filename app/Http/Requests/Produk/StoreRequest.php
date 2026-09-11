<?php

namespace App\Http\Requests\Produk;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'name' => ['required', 'string', 'max:255'],
            'purchase_price' => ['required', 'integer', 'min:0'],
            'selling_price' => ['required', 'integer', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'foto.image' => 'File yang diupload harus berupa gambar.',
            'foto.mimes' => 'Format gambar harus JPG, JPEG, atau PNG.',
            'foto.max' => 'Ukuran gambar maksimal 2 MB.',
            'name.required' => 'Nama wajib diisi.',
            'purchase_price.required' => 'Harga beli wajib diisi.',
            'purchase_price.integer' => 'Harga beli harus berupa angka bulat.',
            'selling_price.required' => 'Harga jual wajib diisi.',
            'selling_price.integer' => 'Harga jual harus berupa angka bulat.',
            'stock.required' => 'Stok wajib diisi.',
            'stock.integer' => 'Stok harus berupa angka bulat.',
        ];
    }
}
