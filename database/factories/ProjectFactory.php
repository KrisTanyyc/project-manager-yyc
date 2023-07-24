<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Project;
use App\Models\Faker;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    protected $model = Project::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'name' => $this->faker->text(20),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
    }

    /**
     * Customize the model instance before it's created.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Project $project) {
            Faker::create([
                'model_id' => $project->id,
                'model' => 'project'
            ]);
            // $moduleData = Module::factory(5)->make();

            // $modules = $project->modules()->saveMany($moduleData);

            // foreach ($moduleData as $data) {
            //     $data->order = $data->id;
            //     $data->save();
            // };

            // $stakeholderData = Stakeholder::factory(5)->make();

            // $project->stakeholders()->saveMany($stakeholderData);

            // foreach ($stakeholderData as $data) {
            //     $data->order = $data->id;
            //     $data->save();
            // };

            // foreach ($modules as $module) {
            //     $actionData = Action::factory(5)->make();
            //     $module->actions()->saveMany($actionData);

            //     foreach ($actionData as $data) {
            //         $data->order = $data->id;
            //         $data->save();
            //     }
            // }

        });
    }
}
