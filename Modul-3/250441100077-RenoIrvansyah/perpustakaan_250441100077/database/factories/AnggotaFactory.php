<?php

namespace Database\Factories;

use Faker\Factory as Faker;
use App\Models\Anggota;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Anggota>
 */
class AnggotaFactory extends Factory
{
    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = Faker::create('id_ID');
        return [
            'nama' => $faker->name(),
            'email' => $faker->unique()->safeEmail(),
            'no_telepon' => $faker->phoneNumber(),
        ];
    }
}
