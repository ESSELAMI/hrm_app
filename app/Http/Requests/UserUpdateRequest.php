<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            // 'username' => "required|min:5|max:25|alpha_dash|unique:users,username,$this->id",
            // 'password' => 'nullable|min:5|max:25|string|confirmed',
            // 'fullname' => 'required|min:5|max:150|string',
            // 'address' => 'required|max:150|string',
            // 'telephone' => "required|unique:users,telephone,$this->id",
            // 'email' => "required|email|unique:users,email,$this->id",
            // 'structure_id' => 'nullable',
            // 'role_id' => 'required',
            // 'permissions' => 'required',
        ];
    }
}
