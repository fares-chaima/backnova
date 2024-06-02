<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $roles = [
            Role::DEFAULT_ROLES["ADMIN"] => [
                'create-user', 'read-user', 'update-user',
                'read-paramaters','create-paramaters','show-paramaters','update-paramaters','delete-paramaters',
                
            ],
            Role::DEFAULT_ROLES["ASA"]  => [
                'create-fournisseur','read-fournisseur','update-fournisseur','delete-fournisseur',
                'show-fournisseur','read-chapter','create-chapter','update-chapter','delete-chapter',
                'read-product','create-product','show-product','update-product','delete-product',
                'read-article','create-article','show-article','update-article','delete-article',
                'show-paramaters','read-BCE','create-BCE','show-BCE','delete-BCE','create-bcq'
            ],
            Role::DEFAULT_ROLES['MAGASINIER'] => [
                
            ],
            Role::DEFAULT_ROLES["CONSOMATEUR"]  => [
                
            ],
            Role::DEFAULT_ROLES["RSR"]  => [
                
            ],
            Role::DEFAULT_ROLES["DIRECTEUR"] => [
                
            ],
        ];
        foreach ($roles as $role => $permissions) {
            $r = Role::create([
                'name' => $role
            ]);
            foreach ($permissions as $name) {
                $permission = Permission::firstWhere('name', $name);
                if (!$permission) {
                    $permission = Permission::create([
                        'name' => $name
                    ]);
                }
                DB::table('role_permission')->insert([
                    'role_id' => $r->id,
                    'permission_id' => $permission->id
                ]);
            }
        }
    }
    }

