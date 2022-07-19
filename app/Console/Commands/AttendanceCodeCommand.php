<?php

namespace App\Console\Commands;

use App\Models\AttendanceCode;
use Illuminate\Console\Command;

class AttendanceCodeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:code';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $random = rand(1, 999);
        AttendanceCode::find(1)->update([
            'code' => $random,
        ]);

        return 0;
    }
}
