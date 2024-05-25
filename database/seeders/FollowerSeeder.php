<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Follower;

class FollowerSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();

        foreach ($users as $user) {
            $followedUsers = $users->where('id', '!=', $user->id)->random(10);
            foreach ($followedUsers as $followedUser) {
                Follower::create([
                    'follower_user_id' => $user->id,
                    'followed_user_id' => $followedUser->id
                ]);
            }
        }
    }
}
