<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmailByUploadStoreRequest extends FormRequest
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

            'SurveyIdU' => ['required', 'integer'],
            'ClientIdU' => ['required', 'integer'],
            'EmailFile' => ['required', 'mimes:xlsx,xls,csv,ods,ots,xml'],
            'AddedBy' => ['required', 'integer'],
        ];
    }
}
