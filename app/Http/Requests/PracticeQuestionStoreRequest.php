<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PracticeQuestionStoreRequest extends FormRequest
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
            'Question' => ['required', 'string'],
            'QuestionAr' => ['required', 'string'],
            'PracticeId' => ['required', 'string'],
            'functionId' => ['required', 'string'],
            'Respondent' => ['required', 'integer'],
            'Status' => ['required'],
        ];
    }
}
