<?php

namespace App\Http\Controllers;

use Faker\Factory as Faker;
use Illuminate\Support\Str;
use App\Models\User;
use App\Jobs\ProcessUsers;
use Illuminate\Support\Facades\Bus;
use Illuminate\Bus\Batch;
use Throwable;

ini_set('memory_limit', '1280M');

class UserController extends Controller
{
    public function index()
    {
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

        /*
        
        untill here the code will take alot of time to execute for only creating the data above, but in your case should the data be ready
        
        */

        // now we will dispatch the jobs to be executed in the background
        // $this->runAllChunksInOneBatch($chunks);

        // now we will dispatch specific number of jobs to be executed in the background
        $this->runSpecificNumberOfChunks($chunks, 3);

        $users = \App\Models\User::paginate(10);

        return response(['success' => true, 'data' => $users]);
    }

    // run all chunks in one batch
    public function runAllChunksInOneBatch($chunks)
    {
        // now we will dispatch the jobs to be executed in the background
        foreach ($chunks as $chunk) {
            // create a batch of jobs
            ProcessUsers::dispatch($chunk);
        }
    }

    // run specific number of chunks in one batch
    public function runSpecificNumberOfChunks($chunks, $numberOfChunks)
    {
        // now we will dispatch the jobs to be executed in the background
        Bus::batch(
            array_map(function ($chunk) {
                return new ProcessUsers($chunk);
            }, array_slice($chunks, 0, $numberOfChunks))
        )->dispatch();
    }
}
