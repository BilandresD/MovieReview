<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
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
        // User::factory(10)->create();
        $user = [
            [
                'email' => 'admin2@email.com',
                'role' => 'admin',
                'password' => bcrypt('1234'),
            ],
            [
                'email' => 'user22@email.com',
                'role' => 'user',
                'password' => bcrypt('1234'), 
            ],
        ];
        foreach ($user as $key => $value){
            User::create($value);
        }
    }
}
