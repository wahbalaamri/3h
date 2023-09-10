<?php

namespace App\Jobs;

use App\Mail\test;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendQueueEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $emails;
    private $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data,$emails)
    {
        //
        $this->emails=$emails;
        $this->data=$data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
			$data=$this->data;
            Mail::to($this->emails)->send(new test($data));

    }
}
