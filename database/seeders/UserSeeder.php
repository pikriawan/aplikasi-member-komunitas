<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Conversation;
use App\Models\MemberProfile;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->member()->create([
            'name' => 'Min Paimin',
            'email' => 'minpaimin@mail.com',
        ]);

        User::factory()->inactiveMember()->create([
            'name' => 'Gus Agus',
            'email' => 'gusagus@mail.com',
        ]);

        User::factory()->staff()->create([
            'name' => 'Nem Painem',
            'email' => 'nempainem@mail.com',
        ]);

        User::factory()->finance()->create([
            'name' => 'Jo Paijo',
            'email' => 'jopaijo@mail.com',
        ]);

        User::factory()->leader()->create([
            'name' => 'Jo Bejo',
            'email' => 'jobejo@mail.com',
        ]);

        User::factory()->superAdmin()->create([
            'name' => 'Met Slamet',
            'email' => 'metslamet@mail.com',
        ]);
    }
}
