<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::where('name', 'admin')->first();
        $admin->givePermissionTo(['create_user', 'read_user', 'view_user', 'update_user', 'delete_user']);

        $user = User::where('email', 'admin@gmail.com')->first();
        $user->assignRole('admin');
    }
}
