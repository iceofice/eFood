<?php

namespace App\Http\Requests;

use App\Models\Table;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTableRequest extends FormRequest
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
        return Table::$rules;
    }

    /**
     * Modify request and get the validator instance for the request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function getValidatorInstance()
    {
        $range = explode(',', $this->request->get('range'));
        $this->request->set('min', (int)$range[0]);
        $this->request->set('max', (int)$range[1]);

        return parent::getValidatorInstance();
    }
}
