<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        // Ensure directory exists
        $storagePath = storage_path('app/public/posts');
        if (!is_dir($storagePath)) {
            mkdir($storagePath, 0755, true);
        }

        // Generate the image and return the relative path
        $imagePath = $this->faker->image($storagePath, 640, 480, null, false);
        
        return [
            'content' => $this->faker->text(200),
            'post_image' => 'storage/posts/' . $imagePath,
            'user_id' => User::factory()
        ];
    }
}
