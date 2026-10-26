<?php

namespace Database\Seeders;

use App\Models\Watch;
use Illuminate\Database\Seeder;

class WatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $watches = [
            [
                'nama' => 'Rolex Submariner Date',
                'brand' => 'Rolex',
                'harga' => 250000000,
                'tahun_rilis' => 2023,
                'tipe_gerakan' => 'Automatic',
                'material' => 'Oystersteel',
                'status' => 'tersedia',
                'foto' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30',
            ],
            [
                'nama' => 'Patek Philippe Nautilus 5711/1R',
                'brand' => 'Patek Philippe',
                'harga' => 1850000000,
                'tahun_rilis' => 2022,
                'tipe_gerakan' => 'Automatic',
                'material' => 'Rose Gold 18k',
                'status' => 'tersedia',
                'foto' => 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9',
            ],
            [
                'nama' => 'Audemars Piguet Royal Oak Jumbo Extra-Thin',
                'brand' => 'Audemars Piguet',
                'harga' => 1200000000,
                'tahun_rilis' => 2023,
                'tipe_gerakan' => 'Automatic',
                'material' => 'Titanium & Platinum',
                'status' => 'tersedia',
                'foto' => 'https://images.unsplash.com/photo-1547996160-71dfabb1d0fa',
            ],
            [
                'nama' => 'Rolex Daytona Cosmograph 116500LN',
                'brand' => 'Rolex',
                'harga' => 580000000,
                'tahun_rilis' => 2024,
                'tipe_gerakan' => 'Automatic',
                'material' => 'Oystersteel & Cerachrom',
                'status' => 'terjual',
                'foto' => 'https://images.unsplash.com/photo-1533139502658-0198f920d8e8',
            ],
            [
                'nama' => 'Richard Mille RM 11-03 Flyback Chronograph',
                'brand' => 'Richard Mille',
                'harga' => 4500000000,
                'tahun_rilis' => 2021,
                'tipe_gerakan' => 'Automatic',
                'material' => 'Carbon TPT',
                'status' => 'tersedia',
                'foto' => 'https://images.unsplash.com/photo-1509042239860-f550ce710b93',
            ],
            [
                'nama' => 'Omega Speedmaster Professional Moonwatch',
                'brand' => 'Omega',
                'harga' => 125000000,
                'tahun_rilis' => 2023,
                'tipe_gerakan' => 'Manual',
                'material' => 'Stainless Steel',
                'status' => 'tersedia',
                'foto' => 'https://images.unsplash.com/photo-1524805444758-089113d48a6d',
            ],
            [
                'nama' => 'Cartier Santos de Cartier',
                'brand' => 'Cartier',
                'harga' => 145000000,
                'tahun_rilis' => 2024,
                'tipe_gerakan' => 'Automatic',
                'material' => 'Yellow Gold 18k & Steel',
                'status' => 'tersedia',
                'foto' => 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa',
            ],
            [
                'nama' => 'Vacheron Constantin Overseas Self-Winding',
                'brand' => 'Vacheron Constantin',
                'harga' => 620000000,
                'tahun_rilis' => 2023,
                'tipe_gerakan' => 'Automatic',
                'material' => 'Stainless Steel',
                'status' => 'terjual',
                'foto' => 'https://images.unsplash.com/photo-1526045478516-99145907023c',
            ],
        ];

        foreach ($watches as $data) {
            Watch::create($data);
        }
    }
}
