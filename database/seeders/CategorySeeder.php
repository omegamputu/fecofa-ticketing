<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Category::create(['name' => 'Support Informatique', 'description' => 'Problèmes liés aux ordinateurs, logiciels, réseaux, etc.']);
        Category::create(['name' => 'Imprimantes', 'description' => 'Problèmes liés aux imprimantes, scanners, photocopieurs, etc.']);  
        Category::create(['name' => 'Réseau / Internet', 'description' => 'Problèmes liés à la connectivité réseau, Wi-Fi, VPN, etc.']);
        Category::create(['name' => 'Comptabilité', 'description' => 'Problèmes liés aux logiciels de comptabilité, facturation, etc.']);
        Category::create(['name' => 'Téléphonie interne', 'description' => 'Problèmes liés aux téléphones de bureau, systèmes VoIP, etc.']);
        Category::create(['name' => 'Autre', 'description' => 'Problèmes divers ne relevant pas des autres catégories.']);
    }
}
