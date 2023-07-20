<?php

namespace App\Http\Requests\wali_murid;

use Illuminate\Foundation\Http\FormRequest;

class WaliMuridStoreRequest extends FormRequest
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
            'murid_id' => 'required|exists:users,id|unique:wali_murids,user_id',
            'username' => 'required|unique:users,username',
            'alamat' => 'required',
            'password' => 'required|confirmed',
        ];
    }
}
