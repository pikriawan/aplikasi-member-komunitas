<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Content;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $staffId = User::where('role', UserRole::Staff)->first()->id;

        $disk = app()->isProduction()
            ? Storage::disk('s3-private')
            : Storage::disk('local');

        Content::factory(20)->video()->create([
            'uploader_id' => $staffId,
            'file_url' => $disk->putFile(public_path('videos/bunny.webm')),
        ]);

        Content::factory(20)->ebook()->create([
            'uploader_id' => $staffId,
            'file_url' => $disk->putFile(public_path('documents/lipsum.pdf')),
        ]);
    }
}
