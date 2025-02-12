<?php

namespace Database\Seeders;

use App\Models\Provinces;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProvincesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Provinces::create(['name' => 'Ahmadi Governorate']);
        Provinces::create(['name' => 'Asimah Governorate']);
        Provinces::create(['name' => 'Farwaniya Governorate']);
        Provinces::create(['name' => 'Hawalli Governorate']);
        Provinces::create(['name' => 'Jahra Governorate']);
        Provinces::create(['name' => 'Mubarak Al-Kabeer Governorate']);
    }
}
