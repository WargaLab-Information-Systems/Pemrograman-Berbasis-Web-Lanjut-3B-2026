<?php

namespace App\Http\Requests;

class UpdateBukuRequest extends StoreBukuRequest
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
     */
    public function rules(): array
    {
        $rules = parent::rules();

        // Menambahkan 'sometimes' agar mendukung update sebagian (Soal 6)
        // tanpa harus menulis ulang seluruh rule (Soal 2b)
        foreach ($rules as $key => $rule) {
            $rules[$key] = 'sometimes|' . $rule;
        }

        return $rules;
    }
}