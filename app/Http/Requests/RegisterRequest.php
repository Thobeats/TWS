<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return ;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'password' => 'required|string',
            'confirm_password' => 'required|same:password',
            'role' => 'required|integer'
        ];
    }
}
