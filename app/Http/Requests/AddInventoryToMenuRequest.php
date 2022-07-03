<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddInventoryToMenuRequest extends FormRequest
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
            'inventory_id'  => 'required|exists:inventories,id|unique:inventory_menu,inventory_id,NULL,id,menu_id,' . $this->menu->id,
            'qty'           => 'required|numeric|min:1',
        ];
    }
}
