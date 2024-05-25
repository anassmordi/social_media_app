<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::get('/', function () {
        return redirect()->route("login");
    });
});
Route::post('/toggle-dark-mode', [ProfileController::class, 'toggleDarkMode'])->name('toggle-dark-mode');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::post('/home', [HomeController::class, 'createPost']);

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/followers', [ProfileController::class, 'followers'])->name('profile.followers');
    Route::get('/profile/following', [ProfileController::class, 'following'])->name('profile.following');
    Route::get('/profile/posts', [ProfileController::class, 'posts'])->name('profile.posts');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile/unfollow/{user}', [ProfileController::class, 'unfollow'])->name('profile.unfollow');
    Route::delete('/profile/remove-follower/{user}', [ProfileController::class, 'removeFollower'])->name('profile.removeFollower');
    Route::get('/profile/find-friends', [ProfileController::class, 'findFriends'])->name('profile.findFriends');
    Route::post('/profile/follow/{user}', [ProfileController::class, 'follow'])->name('profile.follow');
    Route::delete('/profile/posts/{post}', [ProfileController::class, 'deletePost'])->name('profile.deletePost');


    Route::get('/users/{user}', [ProfileController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/followers', [ProfileController::class, 'userFollowers'])->name('users.followers');
    Route::get('/users/{user}/following', [ProfileController::class, 'userFollowing'])->name('users.following');
});
