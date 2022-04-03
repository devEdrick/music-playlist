<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SongFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        static $order = 0;
        $order++; 
        return [
            'title' => "Fake Song Title {$order}",
            'url' => 'https://picsum.photos/id/870/200/300?grayscale&blur=2',
            'duration' => rand(100, 500),
            'artist_name' => $this->faker->name(),
            'created_at' => date('Y-m-d H:i:s', strtotime("+{$order} minutes"))
        ];
    }
}
