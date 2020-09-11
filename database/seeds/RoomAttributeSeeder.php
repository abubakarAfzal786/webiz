<?php

use App\Models\RoomAttribute;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RoomAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        $attributes = [
            [
                'name' => 'Parking',
                'unit' => RoomAttribute::UNIT_HR,
                'price' => 110,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Chair',
                'unit' => RoomAttribute::UNIT_PC,
                'price' => 50,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Computer Screen',
                'unit' => RoomAttribute::UNIT_PC,
                'price' => 90,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Pens for board',
                'unit' => RoomAttribute::UNIT_PC,
                'price' => 40,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        RoomAttribute::query()->insert($attributes);
    }
}
