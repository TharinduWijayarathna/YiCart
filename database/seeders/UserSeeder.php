<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{

    protected $user;

    public function __construct()
    {
        $this->user = new User();
    }

    /**
     * Run the database seeds.
     */
    public function run()
    {
        $initialUsers = [
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => '123456789',
                'user_role' => 1,
                'user_role_id' => 1,

            ],
        ];

        foreach ($initialUsers as $user) {
            $check = User::where('name', $user['name'])->first();
            if (!$check) {
                $this->user->create([
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'password' => Hash::make($user['password']),
                    'user_role' => $user['user_role'],
                    'user_role_id' => $user['user_role_id'],
                ]);
            }
        }
    }
}
