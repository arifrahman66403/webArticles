<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('/login');
    }

    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'g-recaptcha-response' => 'required|captcha',
        ], [
            'g-recaptcha-response.required' => 'Please, click the checkbox reCAPTCHA.',
            'g-recaptcha-response.captcha' => 'reCAPTCHA verification failed, please try again.',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember_me');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Cek redirect sesuai role
            if (Auth::user()->role === 'superadmin') {
                return redirect()->route('home')->with('success', 'Login successfully!'); // route superadmin
            } elseif (Auth::user()->role === 'admin') {
                return redirect()->route('home')->with('success', 'Login successfully!'); // route admin
            } elseif (Auth::user()->role === 'author') {
                return redirect()->route('home')->with('success', 'Login successfully!'); // route author
            } else {
                return redirect()->route('home')->with('success', 'Login successfully!'); // route default for user and guest
            }
        }

        return back()->withErrors([
            'email' => 'Email or password is incorrect.',
        ])->onlyInput('email');
    }

    // Tampilkan form register
    public function showRegistrationForm()
    {
        return view('register');
    }

    // Proses register
    public function register(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'required|string|email|max:100|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Simpan user baru
        $user = User::create([
            'name'              => $validated['name'],
            'username'          => $validated['username'],
            'email'             => $validated['email'],
            'email_verified_at' => now(),
            'password'          => Hash::make($validated['password']),
            'remember_token'    => Str::random(10),
        ]);

        // // Auto login setelah register
        // Auth::login($user);

        return redirect()->route('login')->with('success', 'Registration successfully.');
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout(); // user keluar
        $request->session()->invalidate(); // hancurkan session lama
        $request->session()->regenerateToken(); // membuat CSRF token baru

        return redirect()->route('home')->with('success', 'You have been logged out.');
    }
}
