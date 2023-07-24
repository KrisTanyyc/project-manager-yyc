<?php

namespace Database\Seeders;

use App\Models\Action;
use App\Models\Module;
use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $projects = Project::latest()->take(10)->get();

        foreach ($projects as $project) {
            foreach ($project->modules as $module) {
                $i = rand(1, 5);
                $actions = Action::factory()->count($i)->make();
                $arr = [];
                foreach ($actions as $action) {
                    if (!in_array($action->name, $arr)) {
                        array_push($arr, $action->name);
                        $action->module()->associate($module);
                        $action->save();
                    }
                }
            }
        }
    }
}
