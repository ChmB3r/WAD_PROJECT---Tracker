<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Manga;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->command->info('Fetching top mangas from MyAnimeList...');
        
        try {
            $response = Http::withoutVerifying()->timeout(15)->get('https://api.jikan.moe/v4/top/manga');
            
            if ($response->successful()) {
                $mangas = $response->json()['data'];
                $statuses = ['Plan to read', 'Reading', 'On-hold', 'Completed', 'Dropped'];
                
                foreach ($mangas as $index => $mangaData) {
                    Manga::create([
                        'mal_id' => $mangaData['mal_id'] ?? null,
                        'title' => $mangaData['title'] ?? 'Unknown Title',
                        'type' => $mangaData['type'] ?? 'Manga',
                        'status' => $statuses[array_rand($statuses)], 
                        'image_url' => $mangaData['images']['webp']['image_url'] ?? null,
                        'url' => $mangaData['url'] ?? null,
                    ]);
                }
                $this->command->info('Successfully seeded real manga data from API!');
            } else {
                $this->command->error('Failed to fetch from MyAnimeList API. Falling back to dummy factory.');
                Manga::factory(20)->create();
            }
            
        } catch (\Exception $e) {
            $this->command->error('Error connecting to MyAnimeList API: ' . $e->getMessage() . '. Falling back to dummy factory.');
            Manga::factory(20)->create();
        }
    }
}
