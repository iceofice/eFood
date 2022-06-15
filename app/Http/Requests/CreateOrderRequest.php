<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
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
        $rules = Order::$rules;
        $rules['time'] = 'required';

        return $rules;
    }

    /**
     * Modify request and get the validator instance for the request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function getValidatorInstance()
    {
        if (is_null($this->request->get('reserved_at')) || is_null($this->request->get('time'))) {
            return parent::getValidatorInstance();
        }
        $date = Carbon::createFromFormat('m/d/Y H:i', $this->request->get('reserved_at') . ' ' . $this->request->get('time'));
        $this->request->set('reserved_at', $date);
        return parent::getValidatorInstance();
    }
}
