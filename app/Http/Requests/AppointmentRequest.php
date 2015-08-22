<?php

namespace Zento\Http\Requests;

use Zento\Http\Requests\Request;

class AppointmentRequest extends Request
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
            'title' => 'required|min:3',
            'date' => 'required|regex:/\d{2}\.\d{2}\.\d{4}( \d{2}:\d{2})?/',
            'end_date' => 'required_if:holeday,true|regex:/\d{2}\.\d{2}\.\d{4}( \d{2}:\d{2})?/',
        ];
    }
}
