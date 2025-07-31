<x-app-layout>
    <div x-data="{ showModal: false, deleteUrl: '' }" class="py-12" class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center">
                <h2 class="font-semibold text-3xl text-gray-800 leading-tight mb-10">
                    {{ __('Manajemen Driver') }}
                </h2>
            </div>
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-6">

                    {{-- Pesan Sukses --}}
                    @if(session('success'))
                        <div class="p-4 bg-green-100 text-green-700 border border-green-300 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Header: Judul, Search, Tombol Tambah --}}
                    <div class="flex flex-col sm:flex-row justify-between items-center">
                        <h3 class="text-xl font-bold text-slate-800 mb-4 sm:mb-0">Daftar Driver</h3>
                        <div class="flex items-center space-x-4 w-full sm:w-auto">
                            <form method="GET" action="{{ route('admin.drivers.index') }}"
                                class="flex-grow sm:flex-grow-0">
                                <input type="text" name="search" placeholder="Cari nama atau email..."
                                    value="{{ request('search') }}"
                                    class="w-full px-4 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            </form>
                            <a href="{{ route('admin.drivers.create') }}"
                                class="px-5 py-2 bg-orange-500 text-white font-semibold rounded-lg shadow-md hover:bg-orange-600 transition duration-300 whitespace-nowrap">
                                + Tambah Driver
                            </a>
                        </div>
                    </div>

                    {{-- Tabel Driver --}}
                    <div class="overflow-x-auto border rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Driver</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Kontak</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Kendaraan</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($drivers as $driver)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <img class="h-10 w-10 rounded-full object-cover"
                                                        src="{{ $driver->profile_photo_path ? asset('storage/' . $driver->profile_photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode($driver->name) . '&color=FFFFFF&background=F97316' }}"
                                                        alt="{{ $driver->name }}">
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $driver->name }}</div>
                                                    <div class="text-sm text-gray-500">{{ $driver->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $driver->driverProfile->phone_number ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $driver->driverProfile->vehicleType->name ?? 'N/A' }}</div>
                                            <div class="text-sm text-gray-500">
                                                {{ $driver->driverProfile->license_plate ?? 'N/A' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if (isset($driver->driverProfile->status))
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                        @if($driver->driverProfile->status == 'available') bg-green-100 text-green-800 @endif
                                                        @if($driver->driverProfile->status == 'on_duty') bg-yellow-100 text-yellow-800 @endif
                                                        @if($driver->driverProfile->status == 'offline') bg-gray-200 text-gray-800 @endif">
                                                    {{ ucfirst($driver->driverProfile->status) }}
                                                </span>
                                            @else
                                                <span class="text-xs text-gray-400">Belum ada profil</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('admin.drivers.edit', $driver->id) }}"
                                                class="text-orange-600 hover:text-orange-900">Edit</a>
                                            <form action="{{ route('admin.drivers.destroy', $driver->id) }}" method="POST"
                                                class="inline-block ml-4"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus driver ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" @click.prevent="showModal = true; deleteUrl = $el.closest('form').action"
                                                    class="text-red-600 hover:text-red-900">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                            Tidak ada data driver ditemukan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Link Paginasi --}}
                    <div class="mt-4">
                        {{ $drivers->links() }}
                    </div>

                </div>
            </div>
        </div>

        <div x-show="showModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" style="display: none;">
        
            <div @click.away="showModal = false" x-show="showModal" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 text-center">
        
                <div class="w-16 h-16 mx-auto bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                </div>
        
                <h3 class="text-2xl font-bold mt-4">Hapus Driver?</h3>
                <p class="text-gray-600 mt-2">Apakah Anda yakin ingin menghapus driver ini? Tindakan ini tidak dapat dibatalkan.
                </p>
        
                {{-- Form 'dummy' yang akan di-submit --}}
                <form x-ref="deleteForm" :action="deleteUrl" method="POST">
                    @csrf
                    @method('DELETE')
                </form>
        
                <div class="mt-6 flex justify-center space-x-4">
                    <button @click="showModal = false" class="px-6 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                        Batal
                    </button>
                    <button @click="$refs.deleteForm.submit()"
                        class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>