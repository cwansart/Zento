<?php

namespace Zento\Http\Requests;

use Zento\Http\Requests\Request;

class SeminarRequest extends Request
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
            return action('SeminarController@create');
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
            'street' => 'required|min:2', // we can't use "alpha" here since some streets are abbreviated with a dot
            'housenr' => 'required|min:1|alphanum', // since we save it as a string for occasions like "12b" alphanum's fine
            'zip' => 'digits:5|required', // are there any zipcodes that have more or less than 5 digits?
            'city' => 'min:2|required',
            'date' => 'date|required',
            'title' => 'required|min:3'
        ];
    }
}
