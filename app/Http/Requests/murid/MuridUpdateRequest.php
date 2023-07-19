<?php

namespace App\Http\Requests\murid;

use Illuminate\Foundation\Http\FormRequest;

class MuridUpdateRequest extends FormRequest
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
            "alamat" => "required",
            "kelas_id" => "required|exists:kelas,id",
            "jurusan_id" => "required|exists:jurusans,id",
            "agama_id" => "required|exists:agamas,id",
            "tanggal_lahir" => "required",
            "no_hp" => "required",
        ];
    }
}
