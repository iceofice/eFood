<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
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
        return Order::$rules;
    }

    /**
     * Modify request and get the validator instance for the request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function getValidatorInstance()
    {
        $date = Carbon::createFromFormat('m/d/Y H:i', $this->request->get('date') . ' ' . $this->request->get('time'));
        $this->request->set('reserved_at', $date);
        return parent::getValidatorInstance();
    }
}
