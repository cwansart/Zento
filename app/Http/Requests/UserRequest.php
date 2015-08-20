<?php

namespace Zento\Http\Requests;

use Zento\Http\Requests\Request;

class UserRequest extends Request
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
            'firstname' => 'required|min:2|alpha',
            'lastname' => 'required|min:2|alpha',
            'email' => 'required|email|unique:users,email' . ($this->route()->users != null ? ','.$this->route()->users : ''),
            'password' => 'min:4',
            'birthday' => 'date|required',
            'entry_date' => 'date|required',
            'is_admin' => 'boolean',
            'active' => 'boolean'
        ];
    }
}
