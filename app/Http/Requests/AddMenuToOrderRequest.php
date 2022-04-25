<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddMenuToOrderRequest extends FormRequest
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
            'menu_id'   => 'required|exists:menus,id|unique:menu_order,menu_id,NULL,id,order_id,' . $this->order->id,
            'qty'       => 'required|integer|min:1',
        ];
    }
}
