<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ParkingSlot;

class ParkingSlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data slot parkir yang akan dimasukkan ke database
        $slots = [
            ['nomor_slot' => 'A-01', 'lantai' => 1, 'status' => 'tersedia'],
            ['nomor_slot' => 'A-02', 'lantai' => 1, 'status' => 'tersedia'],
            ['nomor_slot' => 'A-03', 'lantai' => 1, 'status' => 'tersedia'],
            ['nomor_slot' => 'B-01', 'lantai' => 2, 'status' => 'tersedia'],
            ['nomor_slot' => 'B-02', 'lantai' => 2, 'status' => 'tersedia'],
            ['nomor_slot' => 'B-03', 'lantai' => 2, 'status' => 'tersedia'],
        ];

        foreach ($slots as $slot) {
            ParkingSlot::firstOrCreate(
                ['nomor_slot' => $slot['nomor_slot']],
                $slot
            );
        }
    }
}
