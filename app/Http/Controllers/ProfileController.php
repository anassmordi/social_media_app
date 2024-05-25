<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Follower;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    public function loggedInUserFollowers()
    {
        $user = Auth::user();
        $followers = Follower::where('followed_user_id', $user->id)->with('follower')->get();
        return view('profile.followers', compact('followers'));
    }

    public function loggedInUserFollowing()
    {
        $user = Auth::user();
        $following = Follower::where('follower_user_id', $user->id)->with('followed')->get();
        return view('profile.following', compact('following'));
    }

    public function followers(User $user = null)
    {

        if ($user) {
            // If a user is provided, show that user's followers
            $followers = $user->followerUsers()->with('followerUsers')->get();
            return view('users.followers', compact('user', 'followers'));
        } else {
            // If no user is provided, show the logged-in user's followers
            $user = Auth::user();
            $followers = $user->followerUsers()->with('followerUsers')->get();
            return view('profile.followers', compact('user', 'followers'));
        }
    }

    public function following(User $user = null)
    {
        if ($user) {
            // If a user is provided, show that user's following
            $following = $user->followingUsers()->with('followingUsers')->get();
            return view('users.following', compact('user', 'following'));
        } else {
            // If no user is provided, show the logged-in user's following
            $user = Auth::user();
            $following = $user->followingUsers()->with('followingUsers')->get();
            return view('profile.following', compact('user', 'following'));
        }
    }


    public function posts()
    {
        $user = Auth::user();
        $posts = $user->posts()->orderBy('created_at', 'desc')->get();

        return view('profile.posts', compact('user', 'posts'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'full_name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->username = $request->username;
        $user->email = $request->email;
        $user->full_name = $request->full_name;
        $user->birth_date = $request->birth_date;

        if ($request->hasFile('profile_image')) {
            // Delete the old profile image if it exists
            if ($user->profile_image && file_exists(public_path($user->profile_image))) {
                unlink(public_path($user->profile_image));
            }

            $image = $request->file('profile_image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);
            $user->profile_image = 'images/' . $name;
        }

        $user->save();

        return redirect()->route('profile')->with('success', 'Profile updated successfully.');
    }


    public function follow(User $user)
    {
        Auth::user()->following()->attach($user->id);

        return redirect()->back()->with('success', 'Followed User successfully.');
    }

    public function unfollow(User $user)
    {
        Auth::user()->following()->detach($user->id);

        return redirect()->back()->with('success', 'Unfollowed User successfully.');
    }


    public function removeFollower(User $user)
    {
        Auth::user()->followers()->detach($user->id);
        return redirect()->back()->with('success', 'Unfollowed User successfully.');
    }

    public function findFriends()
    {
        $user = Auth::user();
        $followingIds = $user->following()->pluck('followed_user_id')->toArray();
        $friends = User::whereNotIn('id', $followingIds)->where('id', '<>', $user->id)->get();

        return view('profile.find-friends', compact('friends'));
    }


    public function deletePost($postId)
    {
        $post = Auth::user()->posts()->find($postId);
        if ($post) {
            $post->delete();
        }
        return redirect()->back()->with('success', 'Deleted Post successfully.');
    }

    public function toggleDarkMode(Request $request)
    {
        session(['dark_mode' => $request->dark_mode]);
        return response()->json(['status' => 'success']);
    }

    public function show(User $user)
    {
        $isFollowing = Auth::user()->following()->where('followed_user_id', $user->id)->exists();
        $posts = $user->posts()->orderBy('created_at', 'desc')->get();
        return view('users.profile', compact('user', 'isFollowing', 'posts'));
    }
    public function userFollowers(User $user)
    {
        $followers = $user->followers()->with('followers')->get();

        return view('users.followers', compact('user', 'followers'));
    }

    public function userFollowing(User $user)
    {
        $following = $user->following()->with('following')->get();

        return view('users.following', compact('user', 'following'));
    }
}
