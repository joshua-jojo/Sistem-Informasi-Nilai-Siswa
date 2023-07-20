<?php

namespace App\Http\Requests\wali_murid;

use Illuminate\Foundation\Http\FormRequest;

class WaliMuridUpdateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "id" => "required|exists:users,id",
            "nama" => "required",
            "username" => "required",
            "no_hp" => "required",
            "alamat" => "required",
            "murid_id" => "required|exists:users,id",
        ];
    }
}
