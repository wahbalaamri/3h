<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FunctionStoreRequest extends FormRequest
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
            'FunctionTitle' => ['required', 'string'],
            'FunctionTitleAr' => ['required', 'string'],
            'PlanId' => ['required', 'integer'],
            'Respondent' => ['required', 'string'],
            'Status' => ['required'],
        ];
    }
}
