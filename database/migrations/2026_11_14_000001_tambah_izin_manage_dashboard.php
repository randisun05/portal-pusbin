<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /** Izin baru untuk modul Dashboard Eksternal pada instalasi yang sudah berjalan (seeder hanya untuk instalasi baru). */
    public function up()
    {
        // Izin ekspor data pribadi hanya diberikan ke Super Admin (yang selalu lolos pemeriksaan izin).
        if (! DB::table('permissions')->where('slug', 'export-data-pribadi')->exists()) {
            DB::table('permissions')->insert([
                'slug' => 'export-data-pribadi', 'label' => 'Ekspor Data Pribadi per NIP', 'grup' => 'Administrasi',
                'created_at' => now(), 'updated_at' => now(),
            ]);
        }

        if (! DB::table('permissions')->where('slug', 'manage-dashboard')->exists()) {
            $id = DB::table('permissions')->insertGetId([
                'slug' => 'manage-dashboard', 'label' => 'Kelola Dashboard Eksternal', 'grup' => 'Operasional',
                'created_at' => now(), 'updated_at' => now(),
            ]);
        } else {
            $id = DB::table('permissions')->where('slug', 'manage-dashboard')->value('id');
        }

        $roleId = DB::table('roles')->where('name', 'admin')->value('id');
        if ($roleId && ! DB::table('permission_role')->where(['role_id' => $roleId, 'permission_id' => $id])->exists()) {
            DB::table('permission_role')->insert(['role_id' => $roleId, 'permission_id' => $id]);
        }
    }

    public function down()
    {
        $this->hapus('manage-dashboard');
        $this->hapus('export-data-pribadi');
    }

    private function hapus(string $slug): void
    {
        $id = DB::table('permissions')->where('slug', $slug)->value('id');
        if ($id) {
            DB::table('permission_role')->where('permission_id', $id)->delete();
            DB::table('permissions')->where('id', $id)->delete();
        }
    }

};
