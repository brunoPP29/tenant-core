<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('modules')->updateOrInsert(
            ['name' => 'Galeria'],
            [
                'default_settings' => json_encode([
                    'slug' => 'gallery',
                    'layout' => 'grid',
                    'columns' => 3,
                    'image_ratio' => '1:1',
                    'show_titles' => true,
                    'show_description' => false,
                    'allow_download' => false
                ]),
                'is_active' => true,
                'is_core' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        DB::table('modules')->updateOrInsert(
            ['name' => 'Catálogo de Produtos'],
            [
                'default_settings' => json_encode([
                    'slug' => 'catalog',
                    'layout' => 'grid',
                    'show_prices' => true,
                ]),
                'is_active' => true,
                'is_core' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        DB::table('modules')->updateOrInsert(
            ['name' => 'Links'],
            [
                'default_settings' => json_encode([
                    'slug' => 'links',
                    'layout' => 'list',
                ]),
                'is_active' => true,
                'is_core' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
