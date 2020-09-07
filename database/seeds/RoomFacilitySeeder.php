<?php

use App\Models\RoomFacility;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RoomFacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        $facilities = [
            [
                'name' => 'Computer',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Phone',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Board',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Screen(tv)',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        RoomFacility::query()->insert($facilities);
    }
}
