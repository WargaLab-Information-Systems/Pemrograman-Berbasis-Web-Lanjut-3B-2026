<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBukuRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Ubah menjadi true agar request diperbolehkan
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'kategori_id'  => 'required|exists:kategoris,id',
            'judul'        => 'required|string|min:3|max:150',
            'penulis'      => 'required|string|min:3|max:100',
            'tahun_terbit' => 'required|integer|between:1900,' . date('Y'), 
        ];
    }

    /**
     * Custom error messages dalam bahasa Indonesia.
     */
    public function messages(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'string'   => ':attribute harus berupa teks.',
            'min'      => ':attribute minimal :min karakter.',
            'max'      => ':attribute maksimal :max karakter.',
            'exists'   => ':attribute yang dipilih tidak valid.',
            'integer'  => ':attribute harus berupa bilangan bulat.',
            'between'  => ':attribute harus antara :min sampai :max.',
        ];
    }

    /**
     * Nama atribut yang ramah pengguna.
     */
    public function attributes(): array
    {
        return [
            'kategori_id'  => 'kategori',
            'tahun_terbit' => 'tahun terbit',
        ];
    }
}