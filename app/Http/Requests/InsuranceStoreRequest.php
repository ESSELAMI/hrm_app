<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InsuranceStoreRequest extends FormRequest
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
            'started_at' =>  'required',
            'ended_at' =>  'required',
            // 'insurance_company_id' =>  'required',
            'police_number' =>  'required|regex:/^[0-9]*$/|unique:vehicle_insurrances,police_number',
            'cost' =>  'required|numeric|min:0',
        ];
    }
}
