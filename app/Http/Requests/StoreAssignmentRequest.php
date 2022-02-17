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
//            'department' => 'integer',
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

    public function messages()
    {
        return [
            'preambule.string' => __('Преамбула должна быть строкой!'),
            'docuemnt-number.integer' => __('Номер документа должн быть целым числом!'),
            'register-date.date' => __('Дата регистрации должна быть датой!'),
            'author.integer' => __('Автор должен быть установлен!'),
            'addressed.integer' => __('Адресат должен быть установлен!'),
            'executor.integer' => __('Исполнитель должен быть установлен!'),
            'executor.min' => __(' Длинна исполнителя минимум 1!'),
            'deadline.date' => __('Дата выполнения должна быть датой!'),
            'fact-deadline.date' => __('Фактическая дата выполнения должна быть датой!'),
            'status.integer' => __('Статус должен быть установлен!'),
            'status.min' => __('Длина статуса минимум 1!'),
        ];
    }
}
