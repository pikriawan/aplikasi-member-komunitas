<?php

namespace Database\Factories;

use App\Enums\UserRole;
use App\Models\Conversation;
use App\Models\MemberProfile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'telephone' => fake()->phoneNumber(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'is_active' => true,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function member(): Factory
    {
        return $this->state(fn (array $attributes) => [
            'role' => UserRole::Member,
        ])->afterCreating(function (User $user) {
            MemberProfile::create([
                'user_id' => $user->id,
                'expired_date' => now()->addYear(),
            ]);

            Conversation::create([
                'submitter_id' => $user->id,
            ]);
        });
    }

    public function inactiveMember(): Factory
    {
        return $this->state(fn (array $attributes) => [
            'role' => UserRole::Member,
        ])->afterCreating(function (User $user) {
            MemberProfile::create([
                'user_id' => $user->id,
                'expired_date' => now(),
            ]);

            Conversation::create([
                'submitter_id' => $user->id,
            ]);
        });
    }

    public function staff(): Factory
    {
        return $this->state(fn (array $attributes) => [
            'role' => UserRole::Staff,
        ]);
    }

    public function finance(): Factory
    {
        return $this->state(fn (array $attributes) => [
            'role' => UserRole::Finance,
        ]);
    }

    public function leader(): Factory
    {
        return $this->state(fn (array $attributes) => [
            'role' => UserRole::Leader,
        ]);
    }

    public function superAdmin(): Factory
    {
        return $this->state(fn (array $attributes) => [
            'role' => UserRole::SuperAdmin,
        ]);
    }
}
