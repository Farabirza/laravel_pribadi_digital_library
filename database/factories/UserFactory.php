<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\Authority;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        if(!Authority::where('name', 'admin')->first()) {
            $authority = Authority::create(['name' => 'superadmin']);
            $authority = Authority::create(['name' => 'admin']);
        }
        $authority = Authority::where('name', 'user')->first();
        if(!$authority) {
            $authority = Authority::create(['name' => 'user']);
        }
        $authority_id = $authority->id;

        $name = strtolower($this->faker->unique()->name);
        return [
            'authority_id' => $authority_id,
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make("password"), // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
