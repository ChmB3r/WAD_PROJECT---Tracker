<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Manga;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Manga>
 */
class MangaFactory extends Factory
{
    protected $model = Manga::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'mal_id' => $this->faker->numberBetween(1, 100000),
            'title' => $this->faker->sentence(3),
            'type' => $this->faker->randomElement(['Manga', 'Manhwa', 'Manhua']),
            'status' => $this->faker->randomElement(['Plan to read', 'Reading', 'On-hold', 'Completed', 'Dropped']),
            'image_url' => $this->faker->imageUrl(225, 320, 'abstract', true),
            'url' => $this->faker->url(),
        ];
    }
}
