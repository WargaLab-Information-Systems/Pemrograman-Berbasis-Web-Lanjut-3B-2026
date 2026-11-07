<?php

namespace App\Http\Requests;

class UpdateBukuRequest extends StoreBukuRequest
{
    /**
     * Mewarisi semua rule dari StoreBukuRequest, lalu menambahkan 'sometimes'
     * supaya update sebagian (hanya kirim judul) tetap lolos validasi.
     */
    public function rules(): array
    {
        return collect(parent::rules())
            ->map(fn ($rule) => array_merge(['sometimes'], $rule))
            ->all();
    }
}