<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run( Faker $faker)
    {
        for ($i = 40; $i < 80; $i++) {
            DB::table('teachers')->insert([
                'user_id' => $i,
                'subject_name' => $faker->text($maxNbChars = 15),
            ]);
        }
    }
}
