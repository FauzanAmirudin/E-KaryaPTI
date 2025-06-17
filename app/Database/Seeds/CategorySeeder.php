<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Poster',
                'slug' => 'poster',
                'description' => 'Koleksi poster desain grafis, infografis, dan poster ilmiah dari mahasiswa PTI',
                'icon' => 'fas fa-image',
                'is_active' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Video',
                'slug' => 'video',
                'description' => 'Video presentasi, tutorial, dan konten multimedia dari mahasiswa PTI',
                'icon' => 'fas fa-video',
                'is_active' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'PDF',
                'slug' => 'pdf',
                'description' => 'Dokumen PDF seperti laporan, makalah, dan dokumentasi proyek',
                'icon' => 'fas fa-file-pdf',
                'is_active' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Web',
                'slug' => 'web',
                'description' => 'Aplikasi web, website, dan proyek pengembangan web',
                'icon' => 'fas fa-globe',
                'is_active' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Foto',
                'slug' => 'foto',
                'description' => 'Karya fotografi dan dokumentasi visual dari mahasiswa PTI',
                'icon' => 'fas fa-camera',
                'is_active' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Aplikasi',
                'slug' => 'aplikasi',
                'description' => 'Aplikasi mobile, desktop, dan software yang dikembangkan mahasiswa PTI',
                'icon' => 'fas fa-mobile-alt',
                'is_active' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('categories')->insertBatch($categories);
    }
}