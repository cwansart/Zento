<?php

namespace Zento\Http\Requests;

use Zento\Http\Requests\Request;

class ExamAddUserRequest extends Request
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
            'userid' => 'required|numeric',
            'result' => 'required|numeric|between:0,17'
        ];
    }
}
