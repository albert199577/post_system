<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// use Illuminate\Support\Facades\DB; 
// use Illuminate\Support\Str;
use App\Models\User;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // DB::table('users')->insert([
        //     'name' => 'Albert',
        //     'email' => 'albert@gmail.com',
        //     'email_verified_at' => now(),
        //     'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        //     'remember_token' => Str::random(10),
        // ]);

        $doe = User::factory(20)->create();

        $else = User::factory()->Bob()->create();

        // dd(get_class($doe), get_class($else));

        $users = $else->concat([$doe]);

        dd($users->count());
    }
}
