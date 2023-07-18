<?php

namespace App\Http\Requests\murid;

use Illuminate\Foundation\Http\FormRequest;

class MuridStoreRequest extends FormRequest
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
            "nama" => "required",
            "username" => "required|unique:users,username",
            "no_hp" => "required|unique:users,no_hp",
            "password" => "required|confirmed",
            "alamat" => "required",
            "agama" => "required",
            "tanggal_lahir" => "required",
            "kelas_id" => "required",
            "jurusan_id" => "required",
        ];
    }
}
