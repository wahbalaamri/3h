<?php

namespace App\Http\Requests;

use App\Models\RequestService;
use Illuminate\Foundation\Http\FormRequest;
use AuthorizesRequests;

class StoreRequestServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        return  true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'company_name' => ['required', 'string', 'max:255'],
            'company_phone' => ['required', 'string', 'max:255'],
            'fp_name' => ['required', 'string', 'max:255'],
            'fp_email' => ['required', 'string', 'email', 'max:255'],
            'remarks' => ['nullable', 'string'],

        ];
    }
    // messages() method is optional
    public function messages()
    {
        return [
            'required' => __(':attribute is required'),
            'email' => __(':attribute must be a valid email address'),
        ];
    }
    // attributes() method is optional
    public function attributes()
    {
        return [
            'company_name' => __('Company Name'),
            'company_phone' => __('Company Phone'),
            'fp_name' => __('Focal Point Name'),
            'fp_email' => __('Focal Point Email'),
            'remarks' => __('Remarks'),
        ];
    }
}
