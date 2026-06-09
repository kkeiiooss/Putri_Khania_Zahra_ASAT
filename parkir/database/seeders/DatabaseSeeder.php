<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Location;
use App\Models\VehicleType;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Locations: Gedung A, B, C
        Location::create(['location_name' => 'Gedung A', 'max_motorcycle' => 3, 'max_car' => 3, 'max_other' => 3]);
        Location::create(['location_name' => 'Gedung B', 'max_motorcycle' => 3, 'max_car' => 3, 'max_other' => 3]);
        Location::create(['location_name' => 'Gedung C', 'max_motorcycle' => 3, 'max_car' => 3, 'max_other' => 3]);

        // Vehicle Types
        VehicleType::create(['jenis' => 'motorcycle', 'perjam_pertama' => 2000, 'perjam_berikutnya' => 1000, 'max_perhari' => 10000]);
        VehicleType::create(['jenis' => 'car',        'perjam_pertama' => 3000, 'perjam_berikutnya' => 2000, 'max_perhari' => 15000]);
        VehicleType::create(['jenis' => 'other',      'perjam_pertama' => 5000, 'perjam_berikutnya' => 3000, 'max_perhari' => 30000]);
    }
}

