<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PartnerShipPlanStoreRequest extends FormRequest
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
            'PlanTitle' => ['required', 'string'],
            'Objective' => ['required', 'string'],
            'Process' => ['required', 'string'],
            'Report' => ['required', 'string'],
            'DeliveryMode' => ['required', 'string'],
            'Limitations' => ['required', 'string'],
            'PlanTitleAr' => ['required', 'string'],
            'ObjectiveAr' => ['required', 'string'],
            'ProcessAr' => ['required', 'string'],
            'ReportAr' => ['required', 'string'],
            'DeliveryModeAr' => ['required', 'string'],
            'LimitationsAr' => ['required', 'string'],
            'Audience' => ['required', 'integer'],
            'TamplatePath' => ['required', 'string'],
            'Price' => ['required', 'numeric'],
            'PaymentMethod' => ['required', 'integer'],
            'Status' => ['required'],
        ];
    }
}
