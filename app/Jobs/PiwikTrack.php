<?php

namespace App\Jobs;

use App\Contracts\LogContract;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PiwikTrack implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $piwik;
    protected $action;
    protected $response;

    /**
     * Create a new job instance.
     *
     * @param LogContract $piwik
     * @param $action
     * @param $response
     */
    public function __construct(LogContract $piwik, $action , $response)
    {
        $this->piwik = $piwik;
        $this->action = $action;
        $this->response = $response;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->piwik->doTrackEvent('transactional', $this->action, $this->response);
    }
}
