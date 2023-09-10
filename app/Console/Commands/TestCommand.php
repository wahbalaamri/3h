<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'testcommand:log';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $emails = ['wahb@hrfactoryapp.com', 'nabahan@extramiles-om.com ','wahb.alaamri@gmail.com'];
        $data = [
            'subject' => 'This Email To test Schedule sending',
            'body' => 'Hi there this is autmatic test to send an email',
        ];
        $job = (new \App\Jobs\SendQueueEmail($data, $emails))
            ->delay(now()->addSeconds(2));
        dispatch($job);
        return Command::SUCCESS;
    }
}
