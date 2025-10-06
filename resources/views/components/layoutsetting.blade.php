<x-tabbar-setting>
    <x-tab-link-setting href="{{ route('admin.setting.profile.index') }}" :active="request()->is('admin/setting/profile')">Profile</x-tab-link-setting>
    <x-tab-link-setting href="{{ route('admin.setting.users.index') }}" :active="request()->is('admin/setting/users')">Users</x-tab-link-setting>
    <x-tab-link-setting href="{{ route('admin.setting.categories.index') }}" :active="request()->is('admin/setting/categories')">Categories</x-tab-link-setting>
    <x-tab-link-setting href="{{ route('admin.setting.app.index') }}" :active="request()->is('admin/setting/app')">CRUD Options</x-tab-link-setting>
</x-tabbar-setting>
