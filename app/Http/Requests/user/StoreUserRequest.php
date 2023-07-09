<?php

namespace App\Http\Requests\user;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'nama' => 'required',
            'no_hp' => 'required|unique:users,no_hp',
            'username' => 'required|unique:users,username',
            'role_id' => 'required',
            'alamat' => 'required',
            'password' => 'required|confirmed',
        ];
    }
}
