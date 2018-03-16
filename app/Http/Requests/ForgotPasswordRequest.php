<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ForgotPasswordRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // return view('users.user_form');
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
      return [
        'email' => 'required|email|exists:users'
      ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */

    public function messages()
    {
       return [
            'email.required'  => 'Please provide an email address',
            'email.email'     => 'Please provide a valid email address',
            'email.exists'    => 'This email address dose not exists',
        ];
    }
}
