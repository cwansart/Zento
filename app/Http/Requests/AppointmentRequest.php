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

    protected function getRedirectUrl()
    {
        if($this->method() == 'POST') {
            return action('AppointmentController@create');
        }
        return parent::getRedirectUrl();
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
            'start' => 'required|regex:/\d{2}\.\d{2}\.\d{4}( \d{2}:\d{2})?/',
            'end' => 'required_if:allDay,true|regex:/\d{2}\.\d{2}\.\d{4}( \d{2}:\d{2})?/',
            'priority' => 'required_if:train,true|numeric|between:0,3',
        ];
    }
}
