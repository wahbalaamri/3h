<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrioritiesAnswerStoreRequest extends FormRequest
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
            'SurveyId' => ['required', 'integer'],
            'QuestionId' => ['required', 'integer'],
            'AnswerValue' => ['required', 'integer'],
            'AnsweredBy' => ['required', 'integer'],
        ];
    }
}
