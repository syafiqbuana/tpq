<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Bersihkan cache permission Spatie sebelum seeding
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. Definisikan Model yang akan dikelola via Filament (CRUD dasar)
        $filamentModels = [
            'Student',
            'User', // Untuk manajemen data wali murid
            'Attendance',
        ];

        // 3. Definisikan aksi standar (Sederhana, tanpa force-delete/restore)
        $crudActions = [
            'view-any',
            'view',
            'create',
            'update',
            'delete'
        ];

        $adminPermissions = [];

        // 4. Generate & Insert Permission CRUD ke Database
        foreach ($filamentModels as $model) {
            foreach ($crudActions as $action) {
                $permissionName = "{$action} {$model}";
                
                Permission::firstOrCreate([
                    'name' => $permissionName,
                    'guard_name' => 'web'
                ]);
                
                $adminPermissions[] = $permissionName;
            }
        }

        // 5. Tambahkan Custom Permission khusus Admin (Scanner & Export)
        $customAdminPermissions = [
            'scan attendance',
            'export id card',
            'import data',
        ];

        foreach ($customAdminPermissions as $customPermission) {
            Permission::firstOrCreate([
                'name' => $customPermission,
                'guard_name' => 'web'
            ]);
            $adminPermissions[] = $customPermission;
        }

        // 6. Tambahkan Custom Permission khusus Orangtua (Portal Inertia)
        $orangtuaPermissions = [
            'access parent portal',
            'view own student attendance'
        ];

        foreach ($orangtuaPermissions as $parentPermission) {
            Permission::firstOrCreate([
                'name' => $parentPermission,
                'guard_name' => 'web'
            ]);
        }

        // 7. Buat Role dan Sinkronisasi Permission
        // Role Admin: Mendapatkan semua CRUD Filament + Custom Admin
        $roleAdmin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $roleAdmin->syncPermissions($adminPermissions);

        // Role Orangtua: Hanya mendapatkan akses portal dan melihat data anaknya sendiri
        $roleOrangtua = Role::firstOrCreate(['name' => 'parent', 'guard_name' => 'web']);
        $roleOrangtua->syncPermissions($orangtuaPermissions);
        
        $this->command->info('✅ Role dan Permission berhasil di-sync!');
    }
}