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
        $member = User::create([
            'role'      => UserRole::Member,
            'name'      => 'Min Paimin',
            'email'     => 'minpaimin@mail.com',
            'telephone' => fake()->phoneNumber(),
            'password'  => 'password',
            'is_active' => true,
        ]);

        $member->markEmailAsVerified();

        MemberProfile::create([
            'user_id'       => $member->id,
            'expired_date'  => now()->addYear(),
        ]);

        Conversation::create([
            'submitter_id' => $member->id,
        ]);

        $premiumMember = User::create([
            'role'      => UserRole::Member,
            'name'      => 'Gus Agus',
            'email'     => 'gusagus@mail.com',
            'telephone' => fake()->phoneNumber(),
            'password'  => 'password',
            'is_active' => true,
        ]);

        $premiumMember->markEmailAsVerified();

        MemberProfile::create([
            'user_id'       => $premiumMember->id,
            'expired_date'  => now(),
        ]);

        Conversation::create([
            'submitter_id' => $premiumMember->id,
        ]);

        $staff = User::create([
            'role'      => UserRole::Staff,
            'name'      => 'Nem Painem',
            'email'     => 'nempainem@mail.com',
            'telephone' => fake()->phoneNumber(),
            'password'  => 'password',
            'is_active' => true,
        ]);

        $staff->markEmailAsVerified();

        $finance = User::create([
            'role'      => UserRole::Finance,
            'name'      => 'Jo Paijo',
            'email'     => 'jopaijo@mail.com',
            'telephone' => fake()->phoneNumber(),
            'password'  => 'password',
            'is_active' => true,
        ]);

        $finance->markEmailAsVerified();

        $leader = User::create([
            'role'      => UserRole::Leader,
            'name'      => 'Jo Bejo',
            'email'     => 'jobejo@mail.com',
            'telephone' => fake()->phoneNumber(),
            'password'  => 'password',
            'is_active' => true,
        ]);

        $leader->markEmailAsVerified();

        $superAdmin = User::create([
            'role'      => UserRole::SuperAdmin,
            'name'      => 'Met Slamet',
            'email'     => 'metslamet@mail.com',
            'telephone' => fake()->phoneNumber(),
            'password'  => 'password',
            'is_active' => true,
        ]);

        $superAdmin->markEmailAsVerified();
    }
}
