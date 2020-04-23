<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Alexander',
            'email' => 'estudiante@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('123123123'), // password
            'remember_token' => Str::random(10)
        ]);
        factory(User::class,400)->create();
    }
}
