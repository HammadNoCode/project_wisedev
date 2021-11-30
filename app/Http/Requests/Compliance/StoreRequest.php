<?php

namespace App\Http\Requests\Compliance;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'document_id' => 'nullable',
            'applicant_id' => 'nullable',
            'issue_date' => 'nullable',
            'date_checked' => 'nullable',
            'online' => 'nullable',
            'passport_number' => 'nullable',
            'passport_expiry' => 'nullable',
            'visa_number' => 'nullable',
            'visa_type' => 'nullable',
            'hours' => 'nullable',
            'visa_expiry' => 'nullable',
        ];
    }
}
