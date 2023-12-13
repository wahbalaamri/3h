<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendSurvey;
use Illuminate\Support\Facades\Log;

class SendQueueEmail  implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	protected $details;
	protected $users;
    public $timeout = 7200; // 2 hours
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details,$users)
    {
		$this->details = $details;
		$this->users = $users;
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //

		//Mail::to($value->Email)->send(new SendSurvey($data));

		foreach ($this->users as $key => $value) {

            //$input['name'] = $value->name;
            $input['email'] = $value->Email;
			$data=$this->details;
			$data['id']=$value->id;
            Mail::to($value->Email)->send(new SendSurvey($data));
        }
    }
}
