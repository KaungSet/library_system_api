<?php

namespace Database\Seeders;

use App\Models\PermissionGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groups = [
            'Book',
            'Author',
            'Category',
            'Member',
            'Role',
            'User',
        ];

        foreach ($groups as $group) {
            $is_exist = PermissionGroup::where('name', $group)->exists();

            if (!$is_exist) {
                PermissionGroup::create([
                    'name' => $group
                ]);
            }
        }
    }
}
