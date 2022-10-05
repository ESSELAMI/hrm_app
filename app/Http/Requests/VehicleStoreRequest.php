<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VehicleStoreRequest extends FormRequest
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
            'engine' =>  'required',
            'licence_plate' =>  'required|unique:vehicles,licence_plate',
            'old_licence_plate' =>  'required|unique:vehicles,old_licence_plate',
            'status' =>  'required',
            'has_gps_tracker' =>  'required',
            'identification_number' =>  'required|unique:vehicles,identification_number',
            'vehicle_model_id' =>  'required',
            'vehicle_type_id' =>  'required',
            'kilometrage' =>  'required|integer|min:0',
            'energy_type_id' =>  'required',
            'horsepower' =>  'required|integer|min:0',

            'started_at' =>  'required',
            'ended_at' =>  'required',
            // 'insurance_company_id' =>  'required',
            'police_number' =>  'required|unique:vehicles,police_number|numeric|min:0',
            'cost' =>  'required|numeric|min:0',

            'owner_id' =>  'required',
            "decision_file" =>  'required|file',
            'decision_number' =>  'required|numeric|min:0',
            'decision_date' =>  'required',
        ];
    }

    public function messages()
    {
        return [
            'engine' =>  'required',
            'licence_plate' =>  'required|unique:vehicles,licence_plate',
            'old_licence_plate' =>  'required|unique:vehicles,old_licence_plate',
            'status' =>  'required',
            'has_gps_tracker' =>  'required',
            'identification_number' =>  'required|unique:vehicles,identification_number',
            'vehicle_model_id' =>  'required',
            'vehicle_type_id' =>  'required',
            'kilometrage' =>  'required|integer|min:0',
            'energy_type_id' =>  'required',
            'horsepower' =>  'required|integer|min:0',

            'started_at' =>  'required',
            'ended_at' =>  'required',
            // 'insurance_company_id' =>  'required',
            'police_number' =>  'required|unique:vehicles,police_number|integer|min:0',
            'cost' =>  'required|numeric|min:0',

            'owner_id' =>  'required',
            "decision_file.file" =>  'La décicion d\'affectation est obligatoire!',
            'decision_number' =>  'required|integer|min:0',
            'decision_date' =>  'required',
        ];
    }
}
