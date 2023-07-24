<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Action>
 */
class ActionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $actionArray = ['Browse', 'Read', 'Add', 'Edit', 'Delete'];
        $action = $actionArray[array_rand($actionArray)];
        return [
            'name' => $action,
            'created_at' => Carbon::now(),
        ];
    }
}
