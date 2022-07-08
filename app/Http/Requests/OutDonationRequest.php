<?php

namespace App\Http\Requests;

use App\Models\Donation;
use Illuminate\Foundation\Http\FormRequest;

class OutDonationRequest extends FormRequest
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
        $donation = Donation::find(1);
        return [
            'amount' => 'required|numeric|min:0|max:' . $donation->amount
        ];
    }
}
