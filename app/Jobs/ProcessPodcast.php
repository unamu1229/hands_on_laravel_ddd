<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessPodcast implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $param;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($value)
    {
        $this->param = $value;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // テキストファイル作成
        $file = sprintf('%s/%s.txt', storage_path('texts'), date('Q-Ymd-His'));
        touch($file);
        for($i=0; $i< 3000; $i++ ) {
            $current = file_get_contents($file);
            $current .= $i;
            file_put_contents($file, $current);
        }
    }
}
