<x-app-layout>
    {{-- Sembunyikan header default untuk layout layar penuh --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight hidden">
            Lacak Pesanan #{{ $order->id }}
        </h2>
    </x-slot>

    {{-- Layout Utama Split Screen --}}
    <div class="flex flex-col lg:flex-row h-screen">

        <div class="w-full lg:w-1/3 xl:w-1/4 bg-white shadow-lg overflow-y-auto p-6 px-16">
            <h2 class="text-2xl font-bold text-slate-800">Lacak Pesanan</h2>
            <p class="text-sm text-slate-500 mb-6">ID Pesanan: #{{ $order->id }}</p>

            <div class="mt-4">
                <div class="flex items-center space-x-4">
                    <img class="h-16 w-16 rounded-full object-cover"
                        src="{{ $order->driver->profile_photo_path ? asset('storage/' . $order->driver->profile_photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode($order->driver->name) . '&color=FFFFFF&background=F97316' }}"
                        alt="{{ $order->driver->name }}">
                    <div>
                        <p class="font-bold text-slate-800">{{ $order->driver->name }}</p>
                        <p class="text-sm text-slate-500">{{ $order->driver->driverProfile->vehicleType->name }} -
                            {{ $order->driver->driverProfile->license_plate }}
                        </p>
                        <div class="flex items-center text-sm">
                            <svg class="w-4 h-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                            </svg>
                            <span
                                class="font-semibold">{{ number_format($order->driver->driver_ratings_avg_rating, 1) }}</span>
                            <span class="text-slate-400 ml-1">({{ $order->driver->driver_ratings_count }} ulasan)</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Detail Alamat --}}
            <div class="mt-8 pt-6 border-t space-y-4">
                <div class="border-l-4 border-orange-500 pl-3">
                    <p class="text-sm font-semibold text-orange-700">Lokasi Penjemputan</p>
                    <p class="text-base text-slate-800">{{ $order->pickup_address }}</p>
                </div>
                <div class="border-l-4 border-blue-500 pl-3">
                    <p class="text-sm font-semibold text-blue-700">Lokasi Tujuan</p>
                    <p class="text-base text-slate-800">{{ $order->dropoff_address }}</p>
                </div>
            </div>

            <a href="{{ route('orders.history') }}"
                class="mt-8 w-full inline-block text-center px-4 py-3 bg-slate-100 text-slate-700 font-semibold rounded-lg hover:bg-slate-200 transition duration-300">
                Kembali ke Riwayat
            </a>
        </div>

        <div class="w-full lg:w-2/3 xl:w-3/4 h-full flex flex-col">
            {{-- Peta --}}
            <div id="map" class="w-full flex-grow z-0 "></div>

            {{-- Timeline Status Horizontal --}}
            <div class="w-full bg-white p-6 z-10">
                @php
                    $isCreated = true;
                    $isOnTheWay = $order->status == 'on_the_way' || $order->status == 'completed';
                    $isCompleted = $order->status == 'completed';
                @endphp
                <div class="flex items-start">
                    {{-- Step 1: Pesanan Dibuat --}}
                    <div class="flex-1 text-center">
                        <div
                            class="w-8 h-8 mx-auto bg-green-500 text-white rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <p class="mt-2 font-semibold text-sm text-green-600">Pesanan Dibuat</p>
                    </div>

                    {{-- Garis Penghubung 1 --}}
                    <div class="flex-1 flex items-center pt-4">
                        <div class="w-full h-1 {{ $isOnTheWay ? 'bg-green-500' : 'bg-gray-200' }}"></div>
                    </div>

                    {{-- Step 2: Dalam Perjalanan --}}
                    <div class="flex-1 text-center">
                        <div
                            class="w-8 h-8 mx-auto rounded-full flex items-center justify-center {{ $isOnTheWay ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-500' }}">
                            @if ($isOnTheWay)
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M5 13l4 4L19 7"></path>
                                </svg>
                            @else
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10 20a10 10 0 110-20 10 10 0 010 20zm1-11a1 1 0 10-2 0v4a1 1 0 102 0v-4zM9 9a1 1 0 112 0 1 1 0 01-2 0z">
                                    </path>
                                </svg>
                            @endif
                        </div>
                        <p class="mt-2 font-semibold text-sm {{ $isOnTheWay ? 'text-green-600' : 'text-gray-500' }}">
                            Dalam
                            Perjalanan</p>
                    </div>

                    {{-- Garis Penghubung 2 --}}
                    <div class="flex-1 flex items-center pt-4">
                        <div class="w-full h-1 {{ $isCompleted ? 'bg-green-500' : 'bg-gray-200' }}"></div>
                    </div>

                    {{-- Step 3: Tiba di Tujuan --}}
                    <div class="flex-1 text-center">
                        <div
                            class="w-8 h-8 mx-auto rounded-full flex items-center justify-center {{ $isCompleted ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-500' }}">
                            @if ($isCompleted)
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M5 13l4 4L19 7"></path>
                                </svg>
                            @else
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10 20a10 10 0 110-20 10 10 0 010 20zm1-11a1 1 0 10-2 0v4a1 1 0 102 0v-4zM9 9a1 1 0 112 0 1 1 0 01-2 0z">
                                    </path>
                                </svg>
                            @endif
                        </div>
                        <p class="mt-2 font-semibold text-sm {{ $isCompleted ? 'text-green-600' : 'text-gray-500' }}">
                            Tiba
                            di Tujuan</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
        <script>
            // Ambil data dari Blade
            const pickupLat = {{ $order->pickup_lat }};
            const pickupLng = {{ $order->pickup_lng }};
            const dropoffLat = {{ $order->dropoff_lat }};
            const dropoffLng = {{ $order->dropoff_lng }};
            const driverLat = {{ $order->driver->driverProfile->current_lat ?? $order->pickup_lat }};
            const driverLng = {{ $order->driver->driverProfile->current_lng ?? $order->pickup_lng }};
            const driverProfileId = {{ $order->driver->driverProfile->id }};

            // Inisialisasi Peta
            const map = L.map('map').setView([driverLat, driverLng], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

            // Buat ikon khusus
            const driverIcon = L.icon({
                iconUrl: 'https://img.icons8.com/plasticine/100/000000/truck.png',
                iconSize: [50, 50],
                iconAnchor: [25, 50],
            });
            const locationIcon = L.icon({
                iconUrl: 'https://img.icons8.com/office/80/marker.png',
                iconSize: [40, 40],
                iconAnchor: [20, 40],
            });

            // Tambahkan marker awal untuk driver
            const driverMarker = L.marker([driverLat, driverLng], { icon: driverIcon }).addTo(map).bindPopup('<b>Posisi Driver</b>');

            // Gambar rute dan tambahkan marker jemput & tujuan
            L.Routing.control({
                waypoints: [
                    L.latLng(pickupLat, pickupLng),
                    L.latLng(dropoffLat, dropoffLng)
                ],
                routeWhileDragging: false,
                addWaypoints: false,
                createMarker: function (i, waypoint, n) {
                    const markerText = i === 0 ? '<b>Lokasi Jemput</b>' : '<b>Lokasi Tujuan</b>';
                    return L.marker(waypoint.latLng, { icon: locationIcon }).bindPopup(markerText);
                },
                lineOptions: {
                    styles: [{ color: '#F97316', opacity: 0.8, weight: 6 }]
                }
            }).addTo(map);

            // Fungsi untuk mengupdate posisi marker driver
            function updateDriverLocation() {
                // Hanya update jika pesanan masih 'on_the_way'
                if ("{{ $order->status }}" !== "on_the_way") {
                    clearInterval(locationInterval); // Hentikan interval jika order selesai/dibatalkan
                    return;
                }

                fetch("{{ route('driver.location', ['driverProfile' => $order->driver->driverProfile->id]) }}")
                    .then(response => response.json())
                    .then(data => {
                        if (data.latitude && data.longitude) {
                            const newLatLng = new L.LatLng(data.latitude, data.longitude);
                            driverMarker.setLatLng(newLatLng);
                        }
                    })
                    .catch(error => console.error('Gagal mengambil lokasi driver:', error));
            }

            const locationInterval = setInterval(updateDriverLocation, 7000); // Cek lokasi setiap 7 detik

        </script>
    @endpush
</x-app-layout>