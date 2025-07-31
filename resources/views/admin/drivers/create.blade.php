<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Driver Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.drivers.store') }}" method="POST">
                        @csrf
                        {{-- Nama --}}
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                            <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>

                        {{-- Email --}}
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>

                        {{-- Password --}}
                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" name="password" id="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        
                        {{-- ================= BLOK BARU ================= --}}
                        {{-- Alamat Pangkalan --}}
                        <div class="mb-4">
                            <label for="address" class="block text-sm font-medium text-gray-700">Alamat Pangkalan</label>
                            <div id="address-container">
                                <input type="text" name="address" id="address" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Ketik untuk mencari alamat..." required>
                            </div>
                            <input type="hidden" name="address_lat" id="address_lat">
                            <input type="hidden" name="address_lng" id="address_lng">
                        </div>
                        {{-- ================= AKHIR BLOK BARU ================= --}}

                        {{-- Nomor HP --}}
                        <div class="mb-4">
                            <label for="phone_number" class="block text-sm font-medium text-gray-700">Nomor HP</label>
                            <input type="text" name="phone_number" id="phone_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>

                        {{-- No. Polisi --}}
                        <div class="mb-4">
                            <label for="license_plate" class="block text-sm font-medium text-gray-700">No. Polisi</label>
                            <input type="text" name="license_plate" id="license_plate" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>

                        {{-- Jenis Kendaraan --}}
                        <div class="mb-4">
                            <label for="vehicle_type_id" class="block text-sm font-medium text-gray-700">Jenis Kendaraan</label>
                            <select name="vehicle_type_id" id="vehicle_type_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                @foreach($vehicleTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Simpan Driver
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Script untuk Autocomplete.js --}}
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/autoComplete.min.js"></script>
    <script>
        new autoComplete({
            selector: `#address`,
            placeHolder: `Ketik alamat pangkalan...`,
            data: {
                src: async (query) => {
                    if (query.length < 3) return [];
                    try {
                        const source = await fetch(`https://nominatim.openstreetmap.org/search?q=${query}&format=json&addressdetails=1`);
                        const data = await source.json();
                        return data;
                    } catch (error) { return error; }
                },
                keys: ["display_name"],
            },
            resultItem: { highlight: true },
            events: {
                input: {
                    selection: (event) => {
                        const selection = event.detail.selection.value;
                        const lat = selection.lat;
                        const lon = selection.lon;
                        const displayName = selection.display_name;
                        
                        document.getElementById('address').value = displayName;
                        document.getElementById('address_lat').value = lat;
                        document.getElementById('address_lng').value = lon;
                    }
                }
            }
        });
    </script>
    @endpush
</x-app-layout>