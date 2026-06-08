<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Content;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $staffId = User::where('role', UserRole::Staff)->first()->id;

        Content::factory(100)->video()->create([
            'uploader_id' => $staffId,
            'file_url' => '#',
        ]);

        Content::factory(100)->ebook()->create([
            'uploader_id' => $staffId,
            'file_url' => '#',
        ]);
    }
}
