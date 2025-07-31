<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex items-center">
                <h2 class="font-semibold text-3xl text-gray-800 leading-tight mb-8">
                    Driver Dashboard
                </h2>
            </div>
            {{-- Pesan Sukses --}}
            @if(session('success'))
                <div class="p-4 bg-green-100 text-green-700 border border-green-300 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Kolom Kiri: Panel Status & Profil --}}
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white p-6 rounded-lg shadow-md text-center">
                        <img class="h-24 w-24 rounded-full object-cover mx-auto mb-4"
                            src="{{ Auth::user()->profile_photo_path ? asset('storage/' . Auth::user()->profile_photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&color=FFFFFF&background=F97316' }}"
                            alt="{{ Auth::user()->name }}">
                        <h3 class="text-xl font-bold text-slate-800">{{ Auth::user()->name }}</h3>
                        <p class="text-sm text-slate-500">
                            {{ Auth::user()->driverProfile->vehicleType->name ?? 'Kendaraan belum diatur' }}
                        </p>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-lg font-bold text-slate-800 mb-4">Status Anda</h3>
                        <div class="p-4 rounded-md text-center
                                @if($driver->driverProfile->status == 'available') bg-green-50 border-green-200 @endif
                                @if($driver->driverProfile->status == 'on_duty') bg-yellow-50 border-yellow-200 @endif
                                @if($driver->driverProfile->status == 'offline') bg-gray-50 border-gray-200 @endif
                            ">
                            <span class="text-2xl font-bold
                                    @if($driver->driverProfile->status == 'available') text-green-600 @endif
                                    @if($driver->driverProfile->status == 'on_duty') text-yellow-600 @endif
                                    @if($driver->driverProfile->status == 'offline') text-gray-600 @endif
                                ">
                                {{ ucfirst($driver->driverProfile->status) }}
                            </span>
                        </div>

                        @if ($driver->driverProfile->status != 'on_duty')
                            <form action="{{ route('driver.status.update') }}" method="POST" class="mt-4">
                                @csrf
                                @if ($driver->driverProfile->status == 'available')
                                    <input type="hidden" name="status" value="offline">
                                    <button type="submit"
                                        class="w-full px-4 py-3 bg-gray-600 text-white font-bold rounded-lg hover:bg-gray-700 transition duration-300">
                                        Go Offline
                                    </button>
                                @else
                                    <input type="hidden" name="status" value="available">
                                    <button type="submit"
                                        class="w-full px-4 py-3 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700 transition duration-300">
                                        Go Online & Siap Menerima Pesanan
                                    </button>
                                @endif
                            </form>
                        @else
                            <p class="mt-4 text-sm text-center text-slate-500">Selesaikan tugas Anda untuk mengubah status.
                            </p>
                        @endif
                    </div>
                </div>

                {{-- Kolom Kanan: Panel Tugas Aktif --}}
                <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-2xl font-bold text-slate-800 mb-4">Tugas Anda Saat Ini</h3>

                    @if($activeOrder)
                        <div class="space-y-6">
                            {{-- Detail Alamat --}}
                            <div class="space-y-4">
                                <div class="p-4 border-l-4 border-orange-500 bg-orange-50">
                                    <p class="text-sm font-semibold text-orange-700">Lokasi Penjemputan</p>
                                    <p class="text-lg text-slate-800">{{ $activeOrder->pickup_address }}</p>
                                </div>
                                <div class="p-4 border-l-4 border-blue-500 bg-blue-50">
                                    <p class="text-sm font-semibold text-blue-700">Lokasi Tujuan</p>
                                    <p class="text-lg text-slate-800">{{ $activeOrder->dropoff_address }}</p>
                                </div>
                            </div>

                            {{-- Detail Tambahan --}}
                            <div class="border-t pt-4">
                                <p><strong>ID Pesanan:</strong> #{{ $activeOrder->id }}</p>
                                <p><strong>Customer:</strong> {{ $activeOrder->customer->name }}</p>
                                <p><strong>Pendapatan:</strong> <span class="font-bold text-green-600">Rp
                                        {{ number_format($activeOrder->total_price, 0, ',', '.') }}</span></p>
                            </div>

                            {{-- Tombol Aksi --}}
                            @if ($activeOrder->status == 'paid')
                                <form action="{{ route('driver.orders.accept', $activeOrder->id) }}" method="POST" class="mt-4">
                                    @csrf
                                    <button type="submit"
                                        class="w-full px-4 py-3 bg-orange-500 text-white font-bold rounded-lg hover:bg-orange-600 transition transform hover:scale-105 duration-300">
                                        Terima & Jemput Pesanan
                                    </button>
                                </form>
                            @elseif ($activeOrder->status == 'on_the_way')
                                <form action="{{ route('driver.orders.complete', $activeOrder->id) }}" method="POST"
                                    class="mt-4">
                                    @csrf
                                    <button type="submit"
                                        class="w-full px-4 py-3 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition transform hover:scale-105 duration-300">
                                        Selesaikan Pesanan
                                    </button>
                                </form>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" aria-hidden="true">
                                <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="mt-2 text-lg font-medium text-gray-900">Tidak Ada Tugas Aktif</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Anda sedang santai. Set status ke "Available" untuk mulai menerima pesanan.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    @push('scripts')
        <script>
            // ================= PERUBAHAN LOGIKA DI SINI =================
            // Skrip HANYA berjalan jika driver sedang dalam tugas (on_duty)
            @if(Auth::user()->driverProfile->status == 'on_duty')

                document.addEventListener('DOMContentLoaded', function () {
                    console.log("Driver status is 'on_duty'. Starting location script for tracking.");

                    if (navigator.geolocation) {
                        navigator.geolocation.watchPosition(sendLocationToServer, handleError, {
                            enableHighAccuracy: true,
                            timeout: 10000,
                            maximumAge: 0
                        });
                    } else {
                        console.error("Browser Anda tidak mendukung Geolocation.");
                    }
                });

                function sendLocationToServer(position) {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;

                    fetch("{{ route('driver.location.update') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            latitude: latitude,
                            longitude: longitude
                        })
                    })
                        .then(response => response.json())
                        .then(data => console.log('Location updated: ', data.message))
                        .catch(error => console.error('Error updating location:', error));
                }

                function handleError(error) {
                    console.warn(`Geolocation ERROR(${error.code}): ${error.message}`);
                }

            @endif
        </script>
    @endpush
</x-app-layout>