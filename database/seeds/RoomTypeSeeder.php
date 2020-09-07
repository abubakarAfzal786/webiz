<?php

use App\Models\RoomType;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        $types = [
            [
                'name' => 'Meeting room',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Regular office',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        RoomType::query()->insert($types);
    }
}
