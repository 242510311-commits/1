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
            'jenis_produk_id' => ['required', 'integer', 'exists:jenis_produks,id'],
            'name'            => ['required', 'string', 'max:255'],
            'purchase_price'  => ['required', 'numeric', 'min:0'],
            'selling_price'   => ['required', 'numeric', 'min:0'],
            'stock'           => ['required', 'integer', 'min:0'],
            'foto'            => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'jenis_produk_id.required' => 'Jenis produk wajib dipilih.',
            'jenis_produk_id.exists'   => 'Jenis produk tidak valid.',
            'name.required'            => 'Nama produk wajib diisi.',
            'name.max'                 => 'Nama produk maksimal 255 karakter.',
            'purchase_price.required'  => 'Harga beli wajib diisi.',
            'purchase_price.numeric'   => 'Harga beli harus berupa angka.',
            'selling_price.required'   => 'Harga jual wajib diisi.',
            'selling_price.numeric'    => 'Harga jual harus berupa angka.',
            'stock.required'           => 'Stok wajib diisi.',
            'stock.integer'            => 'Stok harus berupa angka bulat.',
            'foto.image'               => 'File harus berupa gambar.',
            'foto.mimes'               => 'Format gambar harus jpeg, png, atau jpg.',
            'foto.max'                 => 'Ukuran gambar maksimal 2MB.',
        ];
    }
}