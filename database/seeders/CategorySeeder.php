<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'name' => 'Undangan',
                'description' => 'Undangan rapat, koordinasi, dll.'
            ],
            [
                'name' => 'Pengumuman',
                'description' => 'Surat-surat yang terkait dengan pengumuman.'
            ],
            [
                'name' => 'Nota Dinas',
                'description' => 'Nota dinas internal/eksternal.'
            ],
            [
                'name' => 'Pemberitahuan',
                'description' => 'Surat pemberitahuan atau informasi.'
            ],
        ];
        foreach ($data as $item) {
            Category::firstOrCreate(['name' => $item['name']], $item);
        }
    }
}
