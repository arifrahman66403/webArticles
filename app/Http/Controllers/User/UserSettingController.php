<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class UserSettingController extends Controller
{
    /**
     * Menampilkan profil user
     */
    public function profile()
    {
        $user = Auth::user();
        
        // menghitung total post dan total likes dengan query builder
        $total_posts = \App\Models\Post::where('author_id', $user->id)
                 ->where('status', 'published')
                 ->count();

        $total_likes = \DB::table('likes')
                ->join('posts', 'likes.post_id', '=', 'posts.id')
                ->where('posts.author_id', $user->id)
                ->count();

        return view('user.profile', compact('user', 'total_posts', 'total_likes'));
    }

    /**
     * Menampilkan form pengaturan user
     */
    public function edit()
    {
        $user = Auth::user();
        return view('user.setting', compact('user'));
    }

    /**
     * Update foto profil user
     */
    public function updateProfilePhoto(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'profile_photo' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048']
        ]);

        // hapus foto lama
        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        $path = $request->file('profile_photo')->store('profile-photos', 'public');
        $user->update(['profile_photo' => $path]);

        return back()->with('success', 'Profile photo updated successfully!');
    }

    /**
     * Update data akun (nama, username, email, password)
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'              => 'required|string|max:255',
            'username'          => ['required', 'string', 'max:255', Rule::unique('users','username')->ignore($user->id)],
            'email'              => ['required','email','max:255', Rule::unique('users','email')->ignore($user->id)],
            'current_password'  => ['required','current_password'], // Validasi password saat ini
            'password'           => ['nullable','min:8','confirmed'],
        ], [
            'current_password.current_password' => 'Current password is incorrect.', // Pesan error custom
        ]);

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Account updated successfully!');
    }

    /**
     * Hapus foto profil user
     */
    public function deleteProfilePhoto()
    {
        $user = Auth::user();

        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
            $user->update(['profile_photo' => null]);
        }

        return back()->with('success', 'Profile photo deleted.');
    }
}
