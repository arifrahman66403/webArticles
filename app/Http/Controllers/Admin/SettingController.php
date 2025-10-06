<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Category;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class SettingController extends Controller
{
    // ===== Profile =====
    public function profileIndex()
    {
        $user = auth()->user();
        return view('admin.setting.profile', compact('user'));
    }

    /**
     * Update data profil (nama, username, email)
     */
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'max:50', Rule::unique('users', 'username')->ignore($user->id)],
            'email'    => ['required', 'email', Rule::unique('users')->ignore($user->id)],
        ]);

        $user->update($validated);

        return back()->with('success', 'Profile updated successfully.');
    }

    /**
     * Update hanya foto profil
     */
    public function updateProfilePhoto(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'profile_photo' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        if ($request->hasFile('profile_photo')) {
            // Hapus foto lama jika ada
            if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            // Simpan foto baru
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $user->update(['profile_photo' => $path]);
        }

        return back()->with('success', 'Profile photo updated successfully.');
    }

    /**
     * Hapus foto profil
     */
    public function deleteProfilePhoto(Request $request)
    {
        $user = $request->user();

        if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
            Storage::disk('public')->delete($user->profile_photo);
            $user->update(['profile_photo' => null]);
        }

        return back()->with('success', 'Profile photo deleted successfully.');
    }

    public function updatePassword(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'current_password' => ['required'],
            'password'         => ['required', 'confirmed', 'min:8'],
        ]);

        if (! Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update(['password' => Hash::make($validated['password'])]);

        return back()->with('success', 'Password updated.');
    }

    // ===== Users =====
    public function usersIndex(Request $request)
    {
        $query = User::query();

        // Filter berdasarkan role jika ada
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Pencarian
        $search = $request->input('search');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        $users = $query->orderBy('name')->get();

        return view('admin.setting.users', compact('users', 'search'));
    }

    public function storeUser(Request $request)
    {
        $this->authorize('create', User::class);

        $data = $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'max:50', 'unique:users,username'],
            'email'    => ['nullable', 'email', 'unique:users,email'],
            'role'     => ['required', Rule::in(['admin', 'author', 'user'])],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        $authUser = auth()->user();

        // Batasan role saat create
        if ($authUser->isAdmin() && $request['role'] === 'admin') {
            return back()->withErrors(['role' => 'Admin cannot create other admins.']);
        }

        $data['password'] = Hash::make($data['password'] ?? 'password');
        $data['email_verified_at'] = now();
        $data['remember_token'] = Str::random(10);

        User::create($data);

        return back()->with('success', 'User added.');
    }

    public function updateUser(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $data = $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'profile_photo' => ['nullable','image','mimes:jpg,jpeg,png','max:2048'],
            'username' => ['required', 'string', 'max:50', Rule::unique('users','username')->ignore($user->id)],
            'email'    => ['nullable', 'email', Rule::unique('users','email')->ignore($user->id)],
            'role'     => ['required', Rule::in(['admin', 'author', 'user'])],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $data['profile_photo'] = $path;
        }

        $user->update($data);

        return back()->with('success', 'User updated.');
    }

    public function deleteUserPhoto(User $user)
    {
        $this->authorize('delete', $user);

        if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
            Storage::disk('public')->delete($user->profile_photo);
            $user->update(['profile_photo' => null]);
        }

        return back()->with('success', 'User profile photo deleted.');
    }

    public function destroyUser(User $user)
    {
        $this->authorize('delete', $user);

        $user->delete();
        return back()->with('success', 'User deleted.');
    }

    // ===== Categories =====
    public function categoriesIndex(Request $request)
    {
        $search = $request->input('search');

        $categories = Category::query()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                             ->orWhere('slug', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->get();

        return view('admin.setting.categories', compact('categories', 'search'));
    }

    public function storeCategory(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:80','unique:categories,name'],
            'color' => ['nullable','string','max:20'],
        ]);

        $data['slug'] = generate_unique_slug($data['name'], 'categories');

        Category::create($data);

        return back()->with('success', 'Category added.');
    }

    public function updateCategory(Request $request, Category $category)
    {
        $data = $request->validate([
            'name'  => ['required','string','max:80', Rule::unique('categories','name')->ignore($category->id)],
            'color' => ['nullable','string','max:20'],
        ]);

        // Jika nama berubah, update slug
        if ($data['name'] !== $category->name) {
            $data['slug'] = generate_unique_slug($data['name'], 'categories', $category->id);
        }

        $category->update($data);

        return back()->with('success', 'Category updated.');
    }

    public function destroyCategory(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Category deleted.');
    }

    // ===== App Setting =====
    public function appSettingIndex()
    {
        $setting = Setting::firstOrCreate(['id' => 1]);
        $all_authors = User::whereIn('role', ['superadmin', 'admin', 'author'])->get();
        $all_categories = Category::all();

        return view('admin.setting.app', compact('setting', 'all_authors', 'all_categories'));
    }

    public function updateApp(Request $request)
    {
        $setting = Setting::firstOrCreate(['id' => 1]);
        $authors = User::whereIn('role', ['superadmin', 'admin', 'author'])->pluck('id')->toArray();
        $categories = Category::pluck('id')->toArray();

        $data = $request->validate([
            'posts_per_page'     => ['required', 'integer', 'min:1', 'max:200'],
            'default_order_by'   => ['required', Rule::in(['created_at','updated_at','title','author'])],
            'default_order_dir'  => ['required', Rule::in(['asc','desc'])],
            'filter_author_id'   => ['nullable', Rule::in($authors)],
            'filter_category_id' => ['nullable', Rule::in($categories)],
        ]);

        $setting->update($data);

        return back()->with('success', 'App settings saved.');
    }
}
