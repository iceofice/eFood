<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use App\Models\Discount;
use Illuminate\Foundation\Http\FormRequest;

class CreateDiscountRequest extends FormRequest
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
        return Discount::$rules;
    }

    /**
     * Modify request and get the validator instance for the request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function getValidatorInstance()
    {
        $start_date = Carbon::parse($this->request->get('start_date'));
        $this->request->set('start_date', $start_date);
        $end_date = Carbon::parse($this->request->get('end_date'));
        $this->request->set('end_date', $end_date);
        return parent::getValidatorInstance();
    }
}
