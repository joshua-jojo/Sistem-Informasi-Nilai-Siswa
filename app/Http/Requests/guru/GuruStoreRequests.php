<?php

namespace App\Http\Requests\guru;

use Illuminate\Foundation\Http\FormRequest;

class GuruStoreRequests extends FormRequest
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
            "alamat" => "required",
            "no_hp" => "required|unique:users,no_hp",
            "username" => "required|unique:users,username",
            "password" => "required|confirmed"
        ];
    }
}
