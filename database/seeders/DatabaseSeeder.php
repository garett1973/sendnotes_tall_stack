<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Note;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

         User::factory()->create([
             'name' => 'Virgis Notes',
             'email' => 'notes@virgis.net',
             'email_verified_at' => now(),
             'password' => static::$password ??= Hash::make('password'),
             'remember_token' => Str::random(10),
         ]);


         User::factory()->create([
             'name' => 'Virgis',
             'email' => 'virgisch@virgis.net',
             'email_verified_at' => now(),
             'password' => static::$password ??= Hash::make('password'),
             'remember_token' => Str::random(10),
         ]);



        User::factory(3)->create();

        $this->call([
            NoteSeeder::class,
        ]);
    }
}
