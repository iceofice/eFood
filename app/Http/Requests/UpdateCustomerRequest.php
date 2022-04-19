<?php

namespace App\Http\Requests;

use App\Models\Customer;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
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
        $rules['email'] = 'required_without:phone|nullable|email|unique:customers,email,' . $this->customer->id;

        // Remove password validation if the customer is not changing their password
        if (!isset($this->password))
            unset($rules['password']);

        return $rules;
    }
}
