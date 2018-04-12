<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Award;

use Carbon\Carbon;

class DistributeMonthlyAwards extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'awards:monthly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Distribute monthly awards';

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
     * @return mixed
     */
    public function handle()
    {
        $date = Carbon::now()->subDay();
        $data = User::select('users.id', 'users.name', 'users.avatar')->topListMonthly($date->month, $date->year)->havingRaw('score > 0')->limit(3)->get();
        $grade = 3;
        $grades = config('grades');
        foreach($data as $row) {
            $award = new Award;
            
            $award->type = 'monthly';
            $award->name = $date->format('n-Y');
            $award->grade = $grade;
            $award->user_id = $row->id;

            $award->save();

            // gimme details
            $this->info("$row->name awarded monthly $grades[$grade]");
            $grade--;
        }
    }
}
