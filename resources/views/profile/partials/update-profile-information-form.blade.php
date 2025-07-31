<section>
    <header>
        <h2 class="text-xl font-bold text-slate-900">
            Informasi Profil
        </h2>
        <p class="mt-1 text-sm text-slate-600">
            Perbarui informasi profil dan alamat email akun Anda.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>
    
    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Foto Profil</label>
            <div class="flex items-center space-x-6">
                <div class="shrink-0">
                    @if (Auth::user()->profile_photo_path)
                        <img class="h-20 w-20 object-cover rounded-full" src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" alt="Current profile photo" />
                    @else
                        <img class="h-20 w-20 object-cover rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=FFFFFF&background=F97316" alt="Default profile photo" />
                    @endif
                </div>
                <label class="block">
                    <span class="sr-only">Pilih foto profil</span>
                    <input type="file" name="profile_photo" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100"/>
                </label>
            </div>
        </div>

        <div>
            <label for="name" class="block text-sm font-medium text-slate-700">Nama</label>
            <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name"
                   class="mt-1 block w-full px-4 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-slate-700">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username"
                   class="mt-1 block w-full px-4 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>
        
        @if (Auth::user()->role == 'driver' && Auth::user()->driverProfile)
        <div class="pt-6 border-t">
            <label class="block text-sm font-medium text-slate-700 mb-2">Foto Kendaraan</label>
            <div class="flex items-center space-x-6">
                <div class="shrink-0">
                    @if (Auth::user()->driverProfile->vehicle_photo_path)
                        <img class="h-24 w-32 object-cover rounded-md" src="{{ asset('storage/' . Auth::user()->driverProfile->vehicle_photo_path) }}" alt="Foto Kendaraan" />
                    @else
                         <div class="h-24 w-32 bg-gray-200 rounded-md flex items-center justify-center text-sm text-gray-500">No Photo</div>
                    @endif
                </div>
                <label class="block">
                    <span class="sr-only">Ganti Foto Kendaraan</span>
                    <input type="file" name="vehicle_photo" class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100"/>
                </label>
            </div>
        </div>
        @endif

        <div class="flex items-center gap-4">
            <button type="submit" class="px-6 py-2 bg-orange-500 text-white font-semibold rounded-lg shadow-md hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition duration-300">
                Simpan
            </button>
        </div>
    </form>
</section>