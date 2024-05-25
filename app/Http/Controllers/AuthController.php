<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'full_name' => 'required',
            'birth_date' => 'required|date',
            'profile_image' => 'nullable|image',
        ]);

        $user = new User();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->full_name = $request->full_name;
        $user->birth_date = $request->birth_date;
        $user->password = Hash::make($request->password);

        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = public_path('storage/profiles');
            
            if (!\File::exists($imagePath)) {
                \File::makeDirectory($imagePath, 0755, true);
            }
            
            $image->move($imagePath, $imageName);
            $user->profile_image = 'storage/profiles/' . $imageName;
        }

        $user->save();

        Auth::login($user);

        return redirect()->route('home')->with('success', 'Registration successful.');
    }
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
{
    $credentials = $request->only('username', 'password');

    // Check if the username exists
    $user = User::where('username', $credentials['username'])->first();
    
    if (!$user) {
        return redirect()->back()->with('error', 'Username is incorrect.');
    }

    // Check if the password is correct
    if (!Auth::attempt($credentials)) {
        return redirect()->back()->with('error', 'Password is incorrect.');
    }

    return redirect()->intended('home');
}

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }
}
