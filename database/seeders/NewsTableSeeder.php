<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class NewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('App\Models\News');

        // Creating 10 dummy news with users in the DB
        for ($i=0; $i < 10; $i++) {
            DB::table('news')->insert([
                'title'=> $faker->sentence($nbWords = 6, $variableNbWords = true),
                'content'=> $faker->text($maxNbChars = 200),
                // making new user everytime a new news is made via seeder
                'user_id'=> User::factory()->create()->id,
                'updated_at' => now(),
                'created_at' => now(),
            ]);
        }

    }
}
