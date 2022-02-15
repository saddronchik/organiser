<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssignmentRequest extends FormRequest
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
            'department' => 'integer|required',
            'preambule' => 'string',
            'docuemnt-number' => 'integer',
            'register-date' => 'date',
            'author' => 'integer|min:1',
            'addressed' => 'integer|min:1',
            'executor' => 'integer|min:1',
            'deadline' => 'date',
            'fact-deadline' => 'date',
            'status' => 'integer|min:1'
        ];
    }
}
