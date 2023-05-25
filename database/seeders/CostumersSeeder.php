<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CostumersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customers = [
            [
                'nik' => '1111111111111111',
                'name' => 'january',
                'number' => '1111111111',
                'gender' => 'L',
                'birth' => '2023-01-01 00:00:00',
                'address' => 'jan',
                'phone' => '111111111111',
                'last_education' => 'jan',
                'profession' => 'jan',
                'status' => 'active',
                'photo' => 'null',
                'joined_at' => '2023-01-01 00:00:00',
            ],[
                'nik' => '2222222222222222',
                'name' => 'feb',
                'number' => '2222222222',
                'gender' => 'L',
                'birth' => '2023-02-01 00:00:00',
                'address' => 'feb',
                'phone' => '222222222222',
                'last_education' => 'feb',
                'profession' => 'feb',
                'status' => 'active',
                'photo' => 'null',
                'joined_at' => '2023-02-01 00:00:00',
            ],[
                'nik' => '3333333333333333',
                'name' => 'mar',
                'number' => '3333333333',
                'gender' => 'L',
                'birth' => '2023-03-01 00:00:00',
                'address' => 'mar',
                'phone' => '333333333333',
                'last_education' => 'mar',
                'profession' => 'mar',
                'status' => 'active',
                'photo' => 'null',
                'joined_at' => '2023-03-01 00:00:00',
            ],[
                'nik' => '4444444444444444',
                'name' => 'apr',
                'number' => '4444444444',
                'gender' => 'L',
                'birth' => '2023-04-01 00:00:00',
                'address' => 'apr',
                'phone' => '444444444444',
                'last_education' => 'apr',
                'profession' => 'apr',
                'status' => 'active',
                'photo' => 'null',
                'joined_at' => '2023-04-01 00:00:00',
            ],[
                'nik' => '5555555555555555',
                'name' => 'may',
                'number' => '5555555555',
                'gender' => 'L',
                'birth' => '2023-05-01 00:00:00',
                'address' => 'may',
                'phone' => '555555555555',
                'last_education' => 'may',
                'profession' => 'may',
                'status' => 'active',
                'photo' => 'null',
                'joined_at' => '2023-05-01 00:00:00',
            ],[
                'nik' => '6666666666666666',
                'name' => 'juni',
                'number' => '6666666666',
                'gender' => 'L',
                'birth' => '2023-06-01 00:00:00',
                'address' => 'jun',
                'phone' => '666666666666',
                'last_education' => 'jun',
                'profession' => 'jun',
                'status' => 'active',
                'photo' => 'null',
                'joined_at' => '2023-06-01 00:00:00',
            ],[
                'nik' => '7777777777777777',
                'name' => 'juli',
                'number' => '7777777777',
                'gender' => 'L',
                'birth' => '2023-07-01 00:00:00',
                'address' => 'jul',
                'phone' => '777777777777',
                'last_education' => 'jul',
                'profession' => 'jul',
                'status' => 'active',
                'photo' => 'null',
                'joined_at' => '2023-07-01 00:00:00',
            ],[
                'nik' => '8888888888888888',
                'name' => 'agustus',
                'number' => '8888888888',
                'gender' => 'L',
                'birth' => '2023-08-01 00:00:00',
                'address' => 'ags',
                'phone' => '888888888888',
                'last_education' => 'ags',
                'profession' => 'ags',
                'status' => 'active',
                'photo' => 'null',
                'joined_at' => '2023-08-01 00:00:00',
            ],[
                'nik' => '9999999999999999',
                'name' => 'september',
                'number' => '9999999999',
                'gender' => 'L',
                'birth' => '2023-09-01 00:00:00',
                'address' => 'sep',
                'phone' => '999999999999',
                'last_education' => 'sep',
                'profession' => 'sep',
                'status' => 'active',
                'photo' => 'null',
                'joined_at' => '2023-09-01 00:00:00',
            ],[
                'nik' => '1010101010101010',
                'name' => 'oktober',
                'number' => '1010101010',
                'gender' => 'L',
                'birth' => '2023-10-01 00:00:00',
                'address' => 'okt',
                'phone' => '101010101010',
                'last_education' => 'okt',
                'profession' => 'okt',
                'status' => 'active',
                'photo' => 'null',
                'joined_at' => '2023-10-01 00:00:00',
            ],[
                'nik' => '1111111111111112',
                'name' => 'november',
                'number' => '1111111112',
                'gender' => 'L',
                'birth' => '2023-11-01 00:00:00',
                'address' => 'nov',
                'phone' => '111111111112',
                'last_education' => 'nov',
                'profession' => 'nov',
                'status' => 'active',
                'photo' => 'null',
                'joined_at' => '2023-11-01 00:00:00',
            ],[
                'nik' => '1111111111111113',
                'name' => 'desember',
                'number' => '1111111113',
                'gender' => 'L',
                'birth' => '2023-12-01 00:00:00',
                'address' => 'des',
                'phone' => '111111111113',
                'last_education' => 'des',
                'profession' => 'des',
                'status' => 'active',
                'photo' => 'null',
                'joined_at' => '2023-12-01 00:00:00',
            ],
        ];
        foreach ($customers as $pelanggan) {
            Customer::create($pelanggan);
        }
    }
}
