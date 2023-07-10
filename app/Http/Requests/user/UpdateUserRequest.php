<?php

namespace App\Http\Requests\user;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        $attribute = $this->all();
        $validasi = [
            "id" => 'required',
            "nama" => 'required',
            "username" => 'required|unique:users,username',
            "no_hp" => 'required|unique:users,no_hp',
            "alamat" => 'required',
            "role_id" => 'required|exists:roles,id',
        ];

        if ($attribute['password']) {
            $validasi['password'] = 'required|confirmed';
        }
        return $validasi;
    }
}
