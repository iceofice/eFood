<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerLoginRequest extends FormRequest
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
        $rules = [
            'email'     => 'required_without:phone|nullable|email',
            'phone'     => 'required_without:email|nullable|numeric',
            'password'  => 'required',
        ];

        return $rules;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function messages()
    {
        return ['required_without' => 'Please provide either an email address or phone number'];
    }

    /**
     * Modify request and get the validator instance for the request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function getValidatorInstance()
    {
        if (is_numeric($this->request->get('email-phone'))) {
            $this->request->set('phone', $this->request->get('email-phone'));
        } elseif (filter_var($this->request->get('email-phone'), FILTER_VALIDATE_EMAIL)) {
            $this->request->set('email', $this->request->get('email-phone'));
        } else {
            $this->redirect = route('front') . '/#profile-section';
            $this->errorBag = 'login';
        }

        return parent::getValidatorInstance();
    }
}
