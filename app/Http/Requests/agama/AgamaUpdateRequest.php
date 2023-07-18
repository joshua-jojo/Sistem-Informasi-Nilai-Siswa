<?php

namespace App\Http\Requests\agama;

use Illuminate\Foundation\Http\FormRequest;

class AgamaUpdateRequest extends FormRequest
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
            "id" => "required|exists:agamas,id",
            "agama" => "required|unique:agamas,agama",
        ];
    }
}
