<section x-data="{ showModal: false }" class="space-y-6">
    <header>
        <h2 class="text-xl font-bold text-slate-900">
            Hapus Akun
        </h2>
        <p class="mt-1 text-sm text-slate-600">
            Setelah akun Anda dihapus, semua datanya akan dihapus secara permanen. Pastikan Anda telah menyimpan
            informasi yang ingin Anda simpan.
        </p>
    </header>

    {{-- Tombol Pemicu Modal --}}
    <x-danger-button @click.prevent="showModal = true">
        Hapus Akun
    </x-danger-button>

    {{-- Modal Konfirmasi --}}
    <div x-show="showModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center bg-white bg-opacity-75 backdrop-blur-sm"
        style="display: none;">

        <div @click.away="showModal = false" x-show="showModal" x-transition
            class="bg-white rounded-lg shadow-xl w-full max-w-md">

            <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                @csrf
                @method('delete')

                <div class="text-center">
                    <div class="w-16 h-16 mx-auto bg-red-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                    </div>
                    <h2 class="mt-4 text-xl font-bold text-gray-900">
                        Apakah Anda yakin?
                    </h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Tindakan ini akan menghapus akun Anda secara permanen. Silakan masukkan password Anda untuk
                        mengonfirmasi.
                    </p>
                </div>

                <div class="mt-6">
                    <label for="password_delete" class="sr-only">{{ __('Password') }}</label>
                    <input id="password_delete" name="password" type="password"
                        class="mt-1 block w-full px-4 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                        placeholder="{{ __('Password') }}" />
                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" @click="showModal = false"
                        class="px-5 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                        Batal
                    </button>
                    <x-danger-button type="submit" class="ms-3">
                        Hapus Akun
                    </x-danger-button>
                </div>
            </form>
        </div>
    </div>
</section>