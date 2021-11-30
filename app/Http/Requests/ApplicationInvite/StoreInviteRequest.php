<?php

namespace App\Http\Requests\ApplicationInvite;

use Illuminate\Foundation\Http\FormRequest;

class StoreInviteRequest extends FormRequest
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
      'position' => 'required',
      'first_name' => 'required',
      'last_name' => 'required',
      'email' => 'required|email',
      'telephone' => 'required',
      'hours_pw' => 'nullable',
      'driving_licence' => 'nullable',
    ];
  }
}
