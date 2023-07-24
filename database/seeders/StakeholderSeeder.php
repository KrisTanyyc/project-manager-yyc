<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Stakeholder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StakeholderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $projects = Project::latest()->take(10)->get();

        foreach ($projects as $project) {
            $j = rand(1, 4);
            $stakeholders = Stakeholder::factory()->count($j)->make();
            $arr = [];
            foreach ($stakeholders as $stakeholder) {
                if (!in_array($stakeholder->name, $arr)) {
                    array_push($arr, $stakeholder->name);
                    $stakeholder->project()->associate($project);
                    $stakeholder->save();
                }
            }
        }
    }
}
