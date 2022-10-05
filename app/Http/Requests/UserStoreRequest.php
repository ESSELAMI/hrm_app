<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'username' => "required|min:5|max:25|alpha_dash|unique:users,username",
            'password' => 'required|min:5|max:25|alpha_dash|confirmed',
            'fullname' => 'required|min:5|max:150',
            'address' => 'required|max:150',
            'telephone' => "required|unique:users,telephone",
            'email' => "required|email|unique:users,email",
            'structure_id' => "nullable",
            'role_id' => "required",
            'permissions' => "required"
        ];
    }

    public function messages()
    {
        return [
            // 'username' => "required|min:5|max:25|alpha_dash|unique:users,username",
            // 'password' => 'required|min:5|max:25|alpha_dash|confirmed',
            'fullname.required' => "Le Nom et le Prénom sont obligatoires",
            // 'address' => 'required|max:150|alpha_dash',
            // 'telephone' => "required|unique:users,telephone",
            // 'email' => "required|email|unique:users,email",
             'role_id.required' => "Veuillez séléctionner un rôle",
             'permissions.required' => "Veuillez séléctionner des permissions"
        ];
    }
}
