<?php

namespace Database\Factories;

use App\Models\Watch;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Watch>
 */
class WatchFactory extends Factory
{
    protected $model = Watch::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $brands = ['Rolex', 'Patek Philippe', 'Audemars Piguet', 'Omega', 'Cartier', 'Richard Mille'];
        $movements = ['Automatic', 'Manual', 'Quartz'];
        $materials = ['Oystersteel', 'Gold 18k', 'Platinum', 'Titanium', 'Rose Gold'];

        return [
            'nama' => fake()->randomElement($brands) . ' ' . fake()->words(2, true),
            'brand' => fake()->randomElement($brands),
            'harga' => fake()->numberBetween(50000000, 2000000000),
            'tahun_rilis' => fake()->numberBetween(2015, (int) date('Y')),
            'tipe_gerakan' => fake()->randomElement($movements),
            'material' => fake()->randomElement($materials),
            'status' => fake()->randomElement(['tersedia', 'terjual']),
            'foto' => fake()->imageUrl(640, 480, 'watch', true),
        ];
    }
}
