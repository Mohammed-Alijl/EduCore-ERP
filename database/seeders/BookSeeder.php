<?php

namespace Database\Seeders;

use App\Models\Academic\Book;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Storage::disk('local')->deleteDirectory('library');
        Storage::disk('local')->makeDirectory('library');

        Book::factory()->count(50)->create();
    }
}
