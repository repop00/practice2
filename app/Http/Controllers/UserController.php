<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function showloginform()
    {
        return view('authenticate');
    }

    public function login(Request $request)
    {
        $credentials  = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:4',
        ]);
        
        if (auth()->attempt($credentials)) {
            return redirect()->route('dashboard')->with('success', 'Login successful!');
        }else{
            return back()->withErrors(['Invalid credentials']);
        }

    }
    public function register(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'profilepic' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => 'required|string|min:4|confirmed',
        ]);

        // User::create([
        //     'name' => $validatedData['name'],
        //     'email' => $validatedData['email'],
        //     'profilepic' => $request->file('profilepic')->store('profile_pics', 'public'),
        //     'password' => bcrypt($validatedData['password']),
        // ]);

        $storefile = $request->file('profilepic')->store('profile_pics', 'public');
        $user = User::create($validatedData);
        if ($user) {
            $user->profilepic = $storefile;
            $user->password = bcrypt($validatedData['password']);
            $user->save();
        }
        Auth()->login($user);

        return redirect()->route('dashboard')->with('success', 'Registration successful!');
    }

    public function logout()
    {
        Auth()->logout();
        return redirect()->route('showloginform')->with('success', 'Logged out successfully!');
    }

    public function dashboard()
    {

        return view('dashboard');
    }
}
