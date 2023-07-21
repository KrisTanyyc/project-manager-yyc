<?php

namespace App\Console\Commands;

use App\Models\Faker;
use App\Models\Project;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DeleteTestingDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'testingdata:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete Testing Data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $project_id = Faker::select('project_id')->get();

        $project = Project::whereIn('id', $project_id)->delete();

        DB::table('fakers')->delete();

        if ($project === 0) {
            $this->info('No testing data found!');
        }
        else {
            $this->info('Testing data deleted!');
        }
        
        
    }
}
