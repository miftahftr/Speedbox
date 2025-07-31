<x-app-layout>
    <x-slot name="header">

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex items-center">
                <h2 class="font-semibold text-3xl text-gray-800 leading-tight mb-8">
                    {{ __('Buat Pesanan Baru') }}
                </h2>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Kolom Kiri: Form Alur Pemesanan --}}
                <div class="lg:col-span-1 space-y-6">
                    {{-- Pesan Error --}}
                    @if ($errors->any() || session('error'))
                        <div class="p-4 bg-red-100 text-red-700 border border-red-300 rounded-lg">
                            <ul class="list-disc list-inside">
                                @if(session('error'))
                                    <li>{{ session('error') }}</li>
                                @endif
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form id="order-form" action="{{ route('orders.store') }}" method="POST" autocomplete="off"
                        class="">
                        @csrf
                        {{-- LANGKAH 1: LOKASI --}}
                        <div class="bg-white p-6 rounded-lg shadow-md mb-4">
                            <div class="flex items-center space-x-3 mb-4">
                                <div
                                    class="flex items-center justify-center w-8 h-8 bg-orange-500 text-white font-bold rounded-full">
                                    1</div>
                                <h3 class="text-xl font-bold text-slate-800">Tentukan Lokasi</h3>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <label for="pickup-search" class="block text-sm font-medium text-gray-700">Alamat
                                        Jemput</label>
                                    <div id="pickup-search-container">
                                        <input type="text" id="pickup-search" name="pickup_address"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-orange-500 focus:border-orange-500"
                                            placeholder="Ketik alamat penjemputan...">
                                    </div>
                                </div>
                                <div>
                                    <label for="dropoff-search" class="block text-sm font-medium text-gray-700">Alamat
                                        Tujuan</label>
                                    <div id="dropoff-search-container">
                                        <input type="text" id="dropoff-search" name="dropoff_address"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-orange-500 focus:border-orange-500"
                                            placeholder="Ketik alamat tujuan...">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- LANGKAH 2: PILIH KENDARAAN (Awalnya tersembunyi) --}}
                        <div id="step-2-container" class="bg-white p-6 rounded-lg shadow-md hidden mb-4">
                            <div class="flex items-center space-x-3 mb-4">
                                <div
                                    class="flex items-center justify-center w-8 h-8 bg-orange-500 text-white font-bold rounded-full">
                                    2</div>
                                <h3 class="text-xl font-bold text-slate-800">Pilih Kendaraan</h3>
                            </div>
                            <div id="vehicle-list" class="space-y-3">
                                {{-- Pilihan kendaraan akan dimuat di sini oleh JavaScript --}}
                            </div>
                        </div>

                        {{-- LANGKAH 3: RINGKASAN & TOMBOL PESAN (Awalnya tersembunyi) --}}
                        <div id="step-3-container" class="bg-white p-6 rounded-lg shadow-md hidden mb-4">
                            <div class="flex items-center space-x-3 mb-4">
                                <div
                                    class="flex items-center justify-center w-8 h-8 bg-orange-500 text-white font-bold rounded-full">
                                    3</div>
                                <h3 class="text-xl font-bold text-slate-800">Konfirmasi Pesanan</h3>
                            </div>
                            <div id="summary" class="space-y-2 text-sm text-slate-600 border-t pt-4">
                                {{-- Ringkasan akan diisi oleh JavaScript --}}
                            </div>
                            <div class="mt-6">
                                <button type="submit"
                                    class="w-full px-4 py-3 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700 transition transform hover:scale-105 duration-300">
                                    Pesan Sekarang & Lanjutkan Pembayaran
                                </button>
                            </div>
                        </div>

                        {{-- Input tersembunyi untuk menyimpan data final --}}
                        <input type="hidden" id="pickup_lat" name="pickup_lat">
                        <input type="hidden" id="pickup_lng" name="pickup_lng">
                        <input type="hidden" id="dropoff_lat" name="dropoff_lat">
                        <input type="hidden" id="dropoff_lng" name="dropoff_lng">
                    </form>
                </div>

                {{-- Kolom Kanan: Peta --}}
                <div class="lg:col-span-2 h-[80vh] sticky top-24">
                    <div id="map" class="w-full h-full rounded-3xl shadow-md z-0"></div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Logika JavaScript dari langkah sebelumnya telah diadaptasi untuk desain baru ini
            const vehicleTypes = @json($vehicleTypes);
            const pricePerKm = 2500;
            const map = L.map('map').setView([-7.7956, 110.3695], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(map);

            let pickupCoords, dropoffCoords;
            let pickupMarker, dropoffMarker;
            let routingControl;

            const step2Container = document.getElementById('step-2-container');
            const step3Container = document.getElementById('step-3-container');

            function calculateRouteAndPrice() {
                if (!pickupCoords || !dropoffCoords) return;
                if (routingControl) { map.removeControl(routingControl); }

                routingControl = L.Routing.control({
                    waypoints: [L.latLng(pickupCoords.lat, pickupCoords.lng), L.latLng(dropoffCoords.lat, dropoffCoords.lng)],
                    routeWhileDragging: false, show: false, addWaypoints: false,
                }).addTo(map);

                routingControl.on('routesfound', function (e) {
                    const route = e.routes[0];
                    const distanceInKm = route.summary.totalDistance / 1000;
                    const vehicleList = document.getElementById('vehicle-list');
                    vehicleList.innerHTML = '';

                    vehicleTypes.forEach(vehicle => {
                        const price = Math.round(parseFloat(vehicle.base_price) + (distanceInKm * pricePerKm));
                        const formattedPrice = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(price);

                        const vehicleElement = `
                                                                            <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:border-orange-500 has-[:checked]:bg-orange-50 has-[:checked]:border-orange-500">
                                                                                <input type="radio" name="vehicle_type_id" value="${vehicle.id}" class="h-4 w-4 text-orange-600 border-gray-300 focus:ring-orange-500" onclick="updateSummary(${distanceInKm}, ${price})">
                                                                                <div class="ml-4 flex-grow">
                                                                                    <p class="text-sm font-bold text-gray-900">${vehicle.name}</p>
                                                                                    <p class="text-xs text-gray-500">Lorem ipsum dolor sit amet.</p>
                                                                                </div>
                                                                                <span class="ml-auto text-sm font-bold text-gray-900">${formattedPrice}</span>
                                                                            </label>
                                                                        `;
                        vehicleList.innerHTML += vehicleElement;
                    });

                    step2Container.classList.remove('hidden');
                });
            }

            function updateSummary(distance, price) {
                const summaryDiv = document.getElementById('summary');
                const formattedPrice = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(price);

                summaryDiv.innerHTML = `
                                                                    <div class="flex justify-between"><span class="text-slate-500">Estimasi Jarak:</span> <span class="font-semibold">${distance.toFixed(2)} km</span></div>
                                                                    <div class="flex justify-between font-bold text-lg"><span class="text-slate-800">Total Harga:</span> <span class="text-orange-600">${formattedPrice}</span></div>
                                                                `;
                step3Container.classList.remove('hidden');
            }

            function updateLocationDetails(mode, lat, lng, label) {
                if (mode === 'pickup') {
                    pickupCoords = { lat, lng };
                    if (pickupMarker) map.removeLayer(pickupMarker);
                    pickupMarker = L.marker([lat, lng]).addTo(map).bindPopup('<b>Lokasi Jemput</b>').openPopup();
                    document.getElementById('pickup-search').value = label;
                    document.getElementById('pickup_lat').value = lat;
                    document.getElementById('pickup_lng').value = lng;
                } else {
                    dropoffCoords = { lat, lng };
                    if (dropoffMarker) map.removeLayer(dropoffMarker);
                    dropoffMarker = L.marker([lat, lng]).addTo(map).bindPopup('<b>Lokasi Tujuan</b>').openPopup();
                    document.getElementById('dropoff-search').value = label;
                    document.getElementById('dropoff_lat').value = lat;
                    document.getElementById('dropoff_lng').value = lng;
                }
                calculateRouteAndPrice();
            }

            function initializeAutocomplete(inputId, mode) {
                new autoComplete({
                    selector: `#${inputId}`,
                    data: {
                        src: async (query) => {
                            if (query.length < 3) return [];
                            const source = await fetch(`https://nominatim.openstreetmap.org/search?q=${query}&format=json&addressdetails=1`);
                            return await source.json();
                        },
                        keys: ["display_name"],
                    },
                    resultItem: { highlight: true },
                    events: {
                        input: {
                            selection: (event) => {
                                const selection = event.detail.selection.value;
                                document.getElementById(inputId).value = selection.display_name;
                                updateLocationDetails(mode, selection.lat, selection.lon, selection.display_name);
                                map.setView([selection.lat, selection.lon], 16);
                            }
                        }
                    }
                });
            }

            initializeAutocomplete('pickup-search', 'pickup');
            initializeAutocomplete('dropoff-search', 'dropoff');
        </script>
    @endpush
</x-app-layout>