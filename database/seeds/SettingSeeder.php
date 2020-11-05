<?php

use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
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
                'key' => 'storage_disk',
                'value' => 'gcs',
                'title' => 'Default disk for storage',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'key' => 'booking_minimum_time',
                'value' => 30,
                'title' => 'Minimum booking time in minutes',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        Setting::query()->insert($types);
    }
}
