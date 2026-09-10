<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $guarded = ['id'];

    /**
     * Daftar tetap permission yang dikenali sistem, dikelompokkan per modul.
     * Dipakai untuk seeding & untuk membangun form checkbox di admin/role.
     */
    public static function definitions(): array
    {
        return [
            'Konten' => [
                'manage-publikasi' => 'Kelola Publikasi',
                'manage-layanan' => 'Kelola Layanan',
                'manage-kegiatan' => 'Kelola Kegiatan',
                'manage-highlight' => 'Kelola Highlight',
                'manage-comment' => 'Moderasi Komentar',
                'manage-faq' => 'Kelola FAQ',
            ],
            'Organisasi' => [
                'manage-organisasi' => 'Kelola Struktur Organisasi',
                'manage-profil' => 'Kelola Profil Organisasi',
                'manage-misi' => 'Kelola Misi',
                'manage-pesankontak' => 'Kelola Pesan Kontak',
            ],
            'Operasional' => [
                'manage-konsultasi' => 'Kelola Konsultasi',
                'manage-repository' => 'Kelola Repository',
                'manage-survei' => 'Kelola Survei',
                'manage-absensi' => 'Kelola Absensi',
                'manage-kodekonsultasi' => 'Kelola Kode Konsultasi',
                'manage-sertifikat' => 'Kelola Sertifikat',
            ],
            'Laporan & Monitoring' => [
                'view-auditlog' => 'Lihat Audit Trail',
                'view-pengunjung' => 'Lihat Monitoring Pengunjung',
                'view-statistik' => 'Lihat Statistik Survei & Absensi',
            ],
            'Administrasi' => [
                'manage-users' => 'Kelola Admin & Role',
            ],
        ];
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
