<?php

namespace App\Http\Requests;

use App\Models\Menu;
use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;

class CreateMenuRequest extends FormRequest
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
        return Menu::$rules;
    }

    /**
     * Modify request and get the validator instance for the request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function getValidatorInstance()
    {
        $this->cleanPrice();
        $this->request->set('featured', $this->boolean('featured'));
        return parent::getValidatorInstance();
    }

    /**
     * Remove comma from price.
     *
     * @return void
     */
    private function cleanPrice()
    {
        $updatedPrice = Str::replace(',', '', $this->request->get('price'));
        $this->request->set('price', $updatedPrice);
    }
}
