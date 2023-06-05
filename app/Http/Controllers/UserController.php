<?php

namespace App\Http\Controllers;

use Faker\Factory as Faker;
use Illuminate\Support\Str;
use App\Models\User;
use App\Jobs\ProcessUsers;

class UserController extends Controller
{
    public function index()
    {
        ini_set('memory_limit', '1280M');

        $faker = Faker::create();
        $data = [];

        for ($i = 0; $i < 500000; $i++) {
            $data[] = [
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
            ];
        }

        $chunks = array_chunk($data, 1000);

        // note
        // untill here the code will take alot of time to execute for only creating the data above, but in your case should the data be ready
        // note

        foreach ($chunks as $chunk) {
            // create a batch of jobs
            ProcessUsers::dispatch($chunk);
        }

        $users = \App\Models\User::paginate(10);


        return response(['success' => true, 'data' => $users]);
    }
}
