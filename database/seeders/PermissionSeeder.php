<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\PermissionGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissionGroups = [
            [
                'name' => 'Author',
                'permissions' => [
                    'author-list',
                    'author-create',
                    'author-edit',
                    'author-delete',
                    'author-detail',
                    'author-export',
                    'author-print'
                ]
            ],

            [
                'name' => 'Role',
                'permissions' => [
                    'role-list',
                    'role-create',
                    'role-edit',
                    'role-delete',
                    'role-detail',
                    'role-export',
                    'role-print'
                ]
            ],

            [
                'name' => 'Category',
                'permissions' => [
                    'category-list',
                    'category-create',
                    'category-edit',
                    'category-delete',
                    'category-detail',
                    'category-export',
                    'category-print'
                ]
            ],

            [
                'name' => 'Book',
                'permissions' => [
                    'book-list',
                    'book-create',
                    'book-edit',
                    'book-delete',
                    'book-detail',
                    'book-export',
                    'book-print'
                ]
            ],

            [
                'name' => 'User',
                'permissions' => [
                    'user-list',
                    'user-create',
                    'user-edit',
                    'user-delete',
                    'user-detail',
                    'user-export',
                    'user-print'
                ]
            ],

            [
                'name' => 'Book Rent',
                'permissions' => [
                    'rent-list',
                    'rent-create',
                    'rent-edit',
                    'rent-delete',
                    'rent-detail',
                    'rent-export',
                    'rent-print'
                ]
            ],

        ];

        foreach ($permissionGroups as $group) {

            $permission_group = PermissionGroup::firstOrCreate([
                'name' => $group['name'],
            ]);

            foreach ($group['permissions'] as $permissionName) {

                Permission::firstOrCreate([
                    'name' => $permissionName,
                    'permission_group_id' => $permission_group->id,
                ]);
            }
        }
    }
}
