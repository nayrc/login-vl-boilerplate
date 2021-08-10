<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AppUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
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
                'au_name' => 'Cryan Fajri',
                'au_email' => 'cryan.fajr@gmail.com',
                'au_password' => Hash::make('nay123'),
            ],
            [
                'au_name' => 'Tuffa',
                'au_email' => 'tuffahati393@gmail.com',
                'au_password' => Hash::make('nay123'),
            ]
        ];

        foreach($data as $key => $datas){
            AppUser::create($datas);
        }
    }
}
