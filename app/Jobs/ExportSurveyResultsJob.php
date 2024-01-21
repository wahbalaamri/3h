<?php

namespace App\Jobs;

use App\Exports\SurveyAnswersExport;
use App\Models\Companies;
use App\Models\Sectors;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ExportSurveyResultsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $id;
    private $type;
    private $type_id;
    public function __construct($id, $type, $type_id)
    {
        //
        $this->id = $id;
        $this->type = $type;
        $this->type_id = $type_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $fileName = '';
        if ($this->type == 'sec') {
            $sector = Sectors::find($this->type_id)->sector_name_en;
            $fileName = $sector . ' - Sector - SurveyAnswers';
        } else if ($this->type == 'comp') {
            $company = Companies::find($this->type_id)->company_name_en;
            $fileName = $company . ' - Company - SurveyAnswers';
        } else if ($this->type == 'all') {
            $fileName = 'All - SurveyAnswers';
        }
        // create .xlsx file in public folder

        Excel::store(new SurveyAnswersExport($this->id, $this->type, $this->type_id), $fileName . '.xlsx');
    }

    // On job complete/
    public function failed()
    {
        // Send user notification of failure, etc...
        Log::info('failed');
    }
    // on success complete
    public function success()
    {
        // Send user notification of success, etc...
        Log::info('success');
    }
}
