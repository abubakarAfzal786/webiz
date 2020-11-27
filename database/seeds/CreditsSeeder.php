<?php

use App\Models\Credit;
use Illuminate\Database\Seeder;

class CreditsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'amount' => 1500,
                'price' => 30,
            ],
            [
                'amount' => 2500,
                'price' => 70,
            ],
            [
                'amount' => 3500,
                'price' => 80,
            ],
            [
                'amount' => 4500,
                'price' => 100,
            ],
        ];

        Credit::query()->insert($data);
    }
}
