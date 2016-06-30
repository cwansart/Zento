<?php

namespace Zento\Http\Requests;

use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Zento\Http\Requests\Request;
use Route;

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
     * Overrides parent getRedirectUrl to redirect to the create action; we need this because
     * otherwise it would use the "back()" url, which is UserController@index in case of
     * the modal create dialog.
     *
     * @return string
     */
    protected function getRedirectUrl()
    {
        if ($this->method() == 'POST') {
            return action('UserController@create');
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
            'firstname' => 'required|min:2|alpha',
            'lastname' => 'required|min:2|alpha',
            'email' => 'required|email|unique:users,email' . ($this->route()->users != null ? ',' . $this->route()->users : ''),
            'password' => 'min:4',
            'birthday' => 'date|required|before:' . Carbon::now()->format('d.m.Y'),
            'entry_date' => 'date|required|before:' . Carbon::now()->addDay()->format('d.m.Y'),
            'is_admin' => 'boolean',
            'active' => 'boolean'
        ];
    }
}
