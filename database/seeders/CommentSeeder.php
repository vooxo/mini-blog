<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $posts = Post::all();

        foreach ($users as $user) {
            $postsToComment = $posts->random(rand(1,10));

            foreach ($postsToComment as $post) {
                Comment::factory()->create([
                    'user_id' => $user->id,
                    'post_id' => $post->id,
                    'created_at' => fake()->dateTimeBetween($post->created_at)
                ]);
            }
        }
    }
}
