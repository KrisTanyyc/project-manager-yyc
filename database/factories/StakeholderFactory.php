<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stakeholder>
 */
class StakeholderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $stakeholdersArray = ['Super Admin','Admin','User','Guest'];
        $stakeholder = $stakeholdersArray[array_rand($stakeholdersArray)];
        return [
            'name' => $stakeholder,
            'created_at' => Carbon::now(),
        ];
    }
}
