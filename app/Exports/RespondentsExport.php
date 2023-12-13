<?php

namespace App\Exports;

use App\Models\Emails;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RespondentsExport implements FromCollection, WithHeadings
{
    private $survey_id;
    private $client_id;

    function __construct($client_id,$survey_id)
    {
        $this->survey_id = $survey_id;
        $this->client_id = $client_id;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $respondent= [];
        foreach (Emails::where([['ClientId',$this->client_id],['SurveyId',$this->survey_id]])->get() as $email) {
            $exportData[] = [
                'Sector' => $email->sector->sector_name_en,
                'Company' => $email->company->company_name_en,
                'Email' =>  $email->Email,
                'Mobile'=>$email->Mobile,
                'Client Comment'=>'Leave your comment here',
            ];
        }
        return collect($exportData);;
    }
    public function headings(): array
    {
        return ['Sector', 'Company','Email','Mobile', 'Client Comment'];
    }
}
