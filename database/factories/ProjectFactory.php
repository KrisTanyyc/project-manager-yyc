<?php

namespace Database\Factories;

use App\Models\Action;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Project;
use App\Models\Faker;
use App\Models\Module;
use App\Models\Stakeholder;

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
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now')
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
                'project_id' => $project->id,
                'project' => $project->name
            ]);
            $moduleData = Module::factory(5)->make();

            $modules = $project->modules()->saveMany($moduleData);

            foreach ($moduleData as $data) {
                $data->order = $data->id;
                $data->save();
            };

            $stakeholderData = Stakeholder::factory(5)->make();

            $project->stakeholders()->saveMany($stakeholderData);

            foreach ($stakeholderData as $data) {
                $data->order = $data->id;
                $data->save();
            };

            foreach ($modules as $module) {
                $actionData = Action::factory(5)->make();
                $module->actions()->saveMany($actionData);

                foreach ($actionData as $data) {
                    $data->order = $data->id;
                    $data->save();
                }
            }

        });
    }
}
