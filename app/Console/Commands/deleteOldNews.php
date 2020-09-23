<?php

namespace App\Console\Commands;

use DateTime;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class deleteOldNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sdui:deleteOldNews';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This commmand will delete all the news older than 14 days';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Calculating -14 days from now and deleting everything less than that date.

        $date = new DateTime();
        $date->modify('-14 days');
        $formatted = $date->format('Y-m-d H:i:s');
        DB::table('news')->where('created_at', '<=', $formatted)->delete();

        echo 'deleteOldNews: news older than 14 days has been deleted\n';
    }
}
