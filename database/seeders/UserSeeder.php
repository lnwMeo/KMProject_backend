<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ลบข้อมูลเก่าออกก่อน
        DB::table('users')->delete();
        $data = [
            'username' => 'catcat',
            'email' => 'cat@email.com',
            'password' => Hash::make('asdf1234'),
            'avatar' => 'https://via.placeholder.com/640x480.png/004466?text=animals+omnis',
            'remember_token' => 'BMXkdoajnk'
        ];

        User::create($data);

        // เรียก UserFactory 
        User::factory(1)->create();
    }
}
