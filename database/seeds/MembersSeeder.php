<?php

use App\Imports\MembersImport;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class MembersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $members = Excel::toArray(new MembersImport(), public_path('WebizDB.xlsx'))[0] ?? [];
        $toSeed = [];
        $companies_ids = Company::query()->pluck('id')->toArray();

        foreach ($members as $member) {
            if (in_array($member['company_id'], $companies_ids)) {
                $created_at = Carbon::createFromFormat('d.m.y', $member['created_at']) ?? Carbon::now();
                $pass = Str::random(6);

                $toSeed[] = [
                    'company_id' => $member['company_id'],
                    'name' => $member['full_name'],
                    'password' => bcrypt($pass),
                    'temp_pass' => $pass,
                    'phone' => '+972' . $member['phone_number'],
                    'created_at' => $created_at,
                    'updated_at' => $created_at,
                ];
            }
        }

        DB::table('members')->insert($toSeed);
    }
}
