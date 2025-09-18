<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserNoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Masukkan data untuk tabel 'users'
        DB::table('users')->insert([
            [
                'name' => 'Zaidan',
                'email' => 'work.muhammadzaidan@gmail.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'celiboy',
                'email' => 'jensenboyy66@gmail.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Masukkan data untuk tabel 'notes'
        // Gunakan user_id yang sesuai dengan data user di atas
        DB::table('notes')->insert([
            [
                'user_id' => 1,
                'title' => 'faef',
                'content' => '<p>adadaw</p>',
                'is_public' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'title' => 'adas',
                'content' => '<p>asdadsa</p>',
                'is_public' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'title' => 'Pembuktiannn',
                'content' => '<p>Halo guys</p>',
                'is_public' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'title' => 'halooo',
                'content' => '<p>haiii</p>',
                'is_public' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
