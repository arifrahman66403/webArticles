<!DOCTYPE html>
<html lang="en" x-data="{ showPassword: false }" class="bg-gray-100 min-h-screen flex items-center justify-center">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <x-script/>
    <title>Login Page</title>
    {{-- reCAPTCHA JS --}}
    {!! NoCaptcha::renderJs() !!}
</head>
<body>

    <div class="w-full max-w-md bg-white shadow-xl rounded-2xl p-8 my-8 transform transition-all duration-500 hover:scale-[1.01]">
        <h2 class="text-3xl font-bold text-center text-gray-800 mx-24 mb-6">Login</h2>

        {{-- Success Message --}}
        @if(session('success'))
            <div 
                x-data="{ show: true }" 
                x-show="show" 
                x-transition 
                x-init="setTimeout(() => show = false, 5000)" 
                class="bg-green-100 text-green-700 p-3 rounded mb-4 text-sm"
            >
                {{ session('success') }}
            </div>
        @endif

        {{-- Error Message --}}
        @if($errors->any())
            <div 
                x-data="{ show: true }" 
                x-show="show" 
                x-transition 
                x-init="setTimeout(() => show = false, 5000)" 
                class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm"
            >
                {{ $errors->first() }}
            </div>
        @endif

        {{-- LOGIN FORM --}}
        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Email -->
            <div>
                <label class="block text-gray-700 mb-1 font-medium">Email</label>
                <input type="email" name="email" required
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all duration-300"
                    placeholder="you@example.com" value="{{ old('email') }}">
            </div>

            <!-- Password -->
            <div>
                <label class="block text-gray-700 mb-1 font-medium">Password</label>
                <div class="relative">
                    <input :type="showPassword ? 'text' : 'password'" name="password" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all duration-300"
                        placeholder="********">
                    <button type="button" @click="showPassword = !showPassword"
                        class="absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-gray-700 focus:outline-none">
                        <!-- Eye -->
                        <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 
                                  8.268 2.943 9.542 7-1.274 4.057-5.065 
                                  7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <!-- Eye Off -->
                        <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 
                                  0-8.268-2.943-9.542-7a9.956 
                                  9.956 0 012.111-3.592M6.23 
                                  6.229A9.953 9.953 0 0112 5c4.477 0 
                                  8.268 2.943 9.542 7a9.953 9.953 
                                  0 01-4.042 5.411M15 12a3 3 0 
                                  11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 3l18 18" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <!-- reCAPTCHA -->
            <div alt="Sorry! Web has bug!">
                {!! NoCaptcha::display() !!}
                @error('g-recaptcha-response')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit -->
            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-300 transform hover:scale-105">
                Login
            </button>
        </form>

        <!-- Divider -->
        <div class="flex items-center my-6">
            <hr class="flex-grow border-gray-300">
            <span class="px-3 text-gray-500 text-sm">OR</span>
            <hr class="flex-grow border-gray-300">
        </div>

        <!-- REGISTER BUTTON -->
        <a href="{{ url('/register') }}"
            class="block w-full text-center bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition duration-300 transform hover:scale-105">
            Create New Account
        </a>

        <!-- GUEST ACCESS -->
        <a href="{{ url('/home') }}"
            class="block text-center text-blue-600 mt-4 hover:underline">
            Continue as Guest
        </a>
    </div>

</body>
</html>