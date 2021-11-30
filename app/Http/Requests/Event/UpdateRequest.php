<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'type' => 'required',
            'attendee_type' => 'required',
            'description' => 'nullable',
            'date' => 'required',
            'time' => 'required',
            'location' => 'required',
            'address' => 'required',
            'postcode' => 'required',
        ];
    }
}
