<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AffectationStoreRequest extends FormRequest
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
            
            'owner_id' =>  'required',
            "uploaded_file" =>  'required|file',
            'decision_number' =>  'required|unique:vehicle_affectations,decision_number|regex:/^[0-9]*$/',
            'assigned_at' =>  'required',
        ];
    }
}
