<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username' => 'wongsodillon',
            'email' => 'wongsodillon@gmail.com',
            'password' => bcrypt("wongsodillon"),
            "balance" => 0,
            "role" => "user",
            "created_at" => Carbon::now()->format('Y-m-d H:i:s'),
            "updated_at" => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        $faker = Faker::create();
        DB::table("users")->insert([
            "username" => "admin",
            "email" => "admin@epicgames.com",
            "password" => bcrypt("admin"),
            "balance" => 0,
            "role" => "admin",
            "created_at" => Carbon::now()->format('Y-m-d H:i:s'),
            "updated_at" => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        for ($i = 1; $i <= 10; $i++) {
            DB::table('users')->insert([
                'username' => $faker->unique()->userName,
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt("123"),
                "balance" => 0,
                "role" => "user",
                "created_at" => Carbon::now()->format('Y-m-d H:i:s'),
                "updated_at" => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        }
    }
}
