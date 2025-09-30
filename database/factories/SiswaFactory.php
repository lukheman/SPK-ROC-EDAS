<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Siswa>
 */
class SiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nisn'            => $this->faker->unique()->numerify('################'), // 16 digit NIK
            'nama'           => $this->faker->name(),
            'status_ekonomi' => $this->faker->randomElement(['Mampu', 'Tidak Mampu', 'Menengah']),
            'phone'          => $this->faker->phoneNumber(),
            'jenis_kelamin'  => $this->faker->randomElement(['L', 'P']),
            'alamat'         => $this->faker->address(),
            'tanggal_lahir'  => $this->faker->date('Y-m-d', '2010-12-31'), // contoh: anak usia sekolah
        ];
    }
}
