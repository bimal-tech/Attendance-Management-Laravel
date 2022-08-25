<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run( Faker $faker)
    {
        for ($i = 1; $i < 20; $i++) {
            DB::table('students')->insert([
                'class' => $faker->numberBetween(0, 100),
                'roll_no' => $faker->numberBetween(0, 100),
                'batch' => $faker->numberBetween(0, 100),
                'user_id' => $i,
            ]);
        }
    }
}
