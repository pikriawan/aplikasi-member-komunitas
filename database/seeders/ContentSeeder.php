<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Content;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $staffId = User::where('role', UserRole::Staff)->first()->id;

        $videoUrl = Storage::putFile(new File(public_path('videos/bunny.mp4')));
        $ebookUrl = Storage::putFile(new File(public_path('documents/hello.pdf')));

        Content::factory(100)->video()->create([
            'uploader_id' => $staffId,
            'file_url' => $videoUrl,
        ]);

        Content::factory(100)->ebook()->create([
            'uploader_id' => $staffId,
            'file_url' => $ebookUrl,
        ]);
    }
}
