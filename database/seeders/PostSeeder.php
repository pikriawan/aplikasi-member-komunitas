<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $staffId = User::where('role', UserRole::Staff)->first()->id;

        Post::factory(100)->create([
            'author_id' => $staffId,
        ]);
    }
}
