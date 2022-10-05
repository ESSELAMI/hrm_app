<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VehicleUpdateRequest extends FormRequest
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
            'licence_plate' =>  "required|unique:vehicles,licence_plate,$this->id",
            'old_licence_plate' => "required|unique:vehicles,old_licence_plate,$this->id",
            'status' =>  'required',
            'has_gps_tracker' =>  'required',
            'identification_number' =>  "required|unique:vehicles,identification_number,$this->id",
            'vehicle_model_id' =>  'required',
            'vehicle_type_id' =>  'required',
            'kilometrage' =>  'required|integer|min:0',
            'energy_type_id' =>  'required',
            'horsepower' =>  'required|integer|min:0',
        ];
    }
}
