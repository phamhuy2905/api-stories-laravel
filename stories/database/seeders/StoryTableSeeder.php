<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class StoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $faker = Faker\Factory::create();

        $limit = 10;

        for ($i = 0; $i < $limit; $i++) {
            DB::table('stories')->insert([
                'name' => Str::random(10),
                'name_author' => Str::random(10),
                'slug' => Str::slug(Str::random(10)),
                'thumbnail' => 'img/story/1764072868141679.jpg',
                'description_short' =>Str::random(100),
                'description_long' =>Str::random(1000),
                'publisher_id' => "1",
                'category_id' => "1",
            ]);
        }
    }
}
