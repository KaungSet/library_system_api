<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::firstOrCreate([
            'name' => 'Super Role'
        ]);

        $permissions = Permission::all();
        Log::info($permissions);
        // Assign all permissions to the 'Admin' role
        $role->permissions()->sync($permissions);

        $is_exist = User::where('name', 'Super Admin')->exists();

        if (!$is_exist) {
            User::create([
                'name' => 'Super Admin',
                'email' => 'superadmin@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => $role->id,
            ]);
        }
    }
}
