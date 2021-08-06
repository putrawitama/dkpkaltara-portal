<?php

use Illuminate\Database\Seeder;
use App\Menu;
use App\SubMenu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menuDefault = [
            0 => [
                'name' => 'Profile',
                'subMenu' => [
                    'Sejarah',
                    'Visi Misi',
                    'Struktur Organisasi'
                ]
            ],
            2 => [
                'name' => 'Layanan',
                'subMenu' => []
            ],
            3 => [
                'name' => 'Informasi',
                'subMenu' => [
                    'Berita',
                    'Artikel',
                    'Agenda',
                    'Pengumuman'
                ]
            ],
            4 => [
                'name' => 'Galeri',
                'subMenu' => []
            ],
            5 => [
                'name' => 'Regulasi',
                'subMenu' => [
                    'Peraturan Daerah',
                    'Peraturan Gubernur'
                ]
            ],
            6 => [
                'name' => 'Kontak',
                'subMenu' => []
            ],

        ];

        foreach ($menuDefault as $key => $value) {
            $id = Menu::insertGetId([
                'name' => $value['name'],
            ]);

            $str = strtolower($value['name']);
            SubMenu::insert([
                'name' => $value['name'],
                'slug' => preg_replace('/\s+/', '-', $str),
                'menu_id' => $id,
                'is_child' => 0
            ]);

            if (count($value['subMenu']) > 0) {
                foreach ($value['subMenu'] as $index => $subValue) {
                    $str = strtolower($subValue);
                    SubMenu::insert([
                        'name' => $subValue,
                        'slug' => preg_replace('/\s+/', '-', $str),
                        'menu_id' => $id,
                        'is_child' => 1
                    ]);
                }
            }
        }
    }
}
