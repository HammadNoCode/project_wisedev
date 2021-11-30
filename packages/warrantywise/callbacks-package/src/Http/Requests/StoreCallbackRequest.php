<?php

namespace Callbacks\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreCallbackRequest extends FormRequest
{
	protected function failedValidation(Validator $validator)
	{
		throw new HttpResponseException(response()->json([
			'message' => $validator->errors()->first()
		], 422));
	}

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
			'staff_id' => 'required|integer',
			'path' => 'required|string',
			'outcome' => 'required|integer',
			'scheduled' => 'required|date',
			'title' => 'required|string'
		];
	}
}
