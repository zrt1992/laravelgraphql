<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        Article::truncate();
//        User::truncate();
//
        $faker = \Faker\Factory::create();
        $password = bcrypt('secret');

        User::create([
            'name'     => $faker->name,
            'email'    => $faker->email,
            'password' => $password,
        ]);

        for ($i = 0; $i < 10; ++$i) {
            User::create([
                'name'     => $faker->name,
                'email'    => $faker->email,
                'password' => $password,
            ]);
        }
    }
}
