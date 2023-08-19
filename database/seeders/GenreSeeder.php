<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $genreList = ["Action", "FPS", "RPG", "Open World", "Horror", "Fighting", "Puzzle", "Indie", "Racing", "Sports", "Stealth", "Sandbox", "MMO", "Battle Royale", "MOBA"];
        for ($i = 0; $i < count($genreList); $i++) {
            DB::table('genre')->insert([
                'genre_name' => $genreList[$i],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        }
    }
}
