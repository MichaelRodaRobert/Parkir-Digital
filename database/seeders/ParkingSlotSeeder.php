<?php

namespace Database\Seeders;

use App\Models\ParkingSlot;
use Illuminate\Database\Seeder;

class ParkingSlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $slots = [
            ['nomor_slot' => 'A-01', 'lantai' => 'Lantai 1', 'harga_per_jam' => 5000],
            ['nomor_slot' => 'A-02', 'lantai' => 'Lantai 1', 'harga_per_jam' => 5000],
            ['nomor_slot' => 'A-03', 'lantai' => 'Lantai 1', 'harga_per_jam' => 5000],
            ['nomor_slot' => 'B-01', 'lantai' => 'Lantai 2', 'harga_per_jam' => 4000],
            ['nomor_slot' => 'B-02', 'lantai' => 'Lantai 2', 'harga_per_jam' => 4000],
        ];

        foreach ($slots as $slot) {
            ParkingSlot::updateOrCreate(
                ['nomor_slot' => $slot['nomor_slot']],
                $slot
            );
        }
    }
}
