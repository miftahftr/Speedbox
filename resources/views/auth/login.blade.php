<x-guest-layout>
    {{-- Judul Form --}}
    <div class="text-center mb-10">
        <h1 class="text-4xl font-bold text-slate-800">Login ke Akun Anda</h1>
        <p class="mt-2 text-slate-600">Belum punya akun? <a href="{{ route('register') }}" class="text-orange-500 hover:underline font-semibold">Daftar di sini</a></p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium text-slate-700">Email</label>
            <div class="mt-1">
                <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                       class="w-full px-4 py-3 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition duration-150"
                       placeholder="you@example.com">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <div class="flex justify-between items-center">
                <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                @if (Route::has('password.request'))
                    <a class="text-sm text-orange-500 hover:underline font-semibold" href="{{ route('password.request') }}">
                        Lupa password?
                    </a>
                @endif
            </div>
            <div class="mt-1">
                <input id="password" type="password" name="password" required autocomplete="current-password"
                       class="w-full px-4 py-3 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition duration-150"
                       placeholder="••••••••">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center">
            <input id="remember_me" type="checkbox" class="h-4 w-4 text-orange-600 border-gray-300 rounded focus:ring-orange-500" name="remember">
            <label for="remember_me" class="ms-2 block text-sm text-gray-900">
                Ingat saya
            </label>
        </div>

        <div>
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-orange-500 hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition duration-300 transform hover:scale-105">
                Login
            </button>
        </div>
    </form>
</x-guest-layout>