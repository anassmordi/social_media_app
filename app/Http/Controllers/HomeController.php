<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->withErrors('You must be logged in to view this page.');
        }

        // Get the IDs of users that the logged-in user follows
        $followingIds = $user->following()->pluck('followed_user_id');

        // Get the posts from those users
        $posts = Post::whereIn('user_id', $followingIds)->latest()->get();

        return view('home', compact('posts'));
    }

    public function createPost(Request $request)
    {
        $request->validate([
            'content' => 'required',
            'post_image' => 'nullable|image'
        ]);

        $post = new Post();
        $post->content = $request->content;
        $post->user_id = Auth::id();

        if ($request->hasFile('post_image')) {
            $image = $request->file('post_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = public_path('posts');
            
            if (!File::exists($imagePath)) {
                File::makeDirectory($imagePath, 0755, true);
            }
            
            $image->move($imagePath, $imageName);
            $post->post_image = 'posts/' . $imageName;
        }

        $post->save();

        return redirect()->back()->with('success', 'Post created successfully.');
    }
    
}
