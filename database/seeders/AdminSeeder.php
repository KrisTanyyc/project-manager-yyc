<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $users = [
            [
                'id' => '1',
                'name' => 'Admin',
                'email' => 'dev@taxpod.my',
                'password' => Hash::make('taxpod88!'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
        ];

        $admin = User::updateOrCreate(['id' => $users[0]['id']], $users[0]);
        $admin->roles()->sync(1);
    }
}
