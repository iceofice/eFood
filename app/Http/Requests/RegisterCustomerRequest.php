<?php

namespace App\Http\Requests;

use App\Models\Customer;
use Illuminate\Foundation\Http\FormRequest;

class RegisterCustomerRequest extends FormRequest
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
        $rules = Customer::$rules;
        if ($this->request->get('email') !== null) {
            $customer = Customer::where('email', $this->request->get('email'))->first();
        } else {
            $customer = Customer::where('phone', $this->request->get('phone'))->first();
        }
        if ($customer) {
            $rules['email'] = '';
            $rules['phone'] = '';
        }
        return $rules;
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
        }

        $this->errorBag = 'register';
        $this->redirect = route('front') . '/#profile-section';

        return parent::getValidatorInstance();
    }
}
