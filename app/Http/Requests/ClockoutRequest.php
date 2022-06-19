<?php

namespace App\Http\Requests;

use App\Models\AttendanceCode;
use Illuminate\Foundation\Http\FormRequest;

class ClockoutRequest extends FormRequest
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
        $this->errorBag = 'clockout';
        $code = AttendanceCode::first()->attendanceCode;
        return [
            'code' => 'required|digits:3|in:' . $code
        ];
    }
}
