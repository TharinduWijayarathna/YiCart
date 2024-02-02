<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    protected $role;

    public function __construct()
    {
        $this->role = new Role();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'Admin',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Cashier',
                'guard_name' => 'web',
            ],
        ];

        foreach ($roles as $role) {
            $old_role = $this->role->where('name', $role['name'])->first();
            if (!$old_role) {
                $this->role->create($role);
            }
        }
    }
}
