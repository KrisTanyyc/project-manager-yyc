<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Module;
use App\Models\Project;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $projects = Project::latest()->take(10)->get();

        foreach ($projects as $project) {
            $j = rand(1, 5);
            $modules = Module::factory()->count($j)->make();
            foreach ($modules as $module) {
                $module->project()->associate($project);
                $module->save();
            }
        }
    }
}
