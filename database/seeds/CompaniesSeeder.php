<?php

use App\Imports\CompaniesImport;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class CompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies = Excel::toArray(new CompaniesImport(), public_path('WebizDB.xlsx'))[1] ?? [];
        $toSeed = [];

        foreach ($companies as $company) {
            if (($company['company_id'] == '42900') && !$company['current_amount']) continue;
            $created_at = Carbon::createFromFormat('d.m.y', $company['created_at']) ?? Carbon::now();

            $toSeed[] = [
                'id' => $company['company_id'],
                'name' => $company['name'],
                'balance' => $company['current_amount'],
                'added_every_month' => $company['added_every_month'],
                'created_at' => $created_at,
                'updated_at' => $created_at,
            ];
        }

        DB::table('companies')->insert($toSeed);
    }
}
