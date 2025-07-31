<x-app-layout>
    {{-- Kita sembunyikan header default untuk tampilan yang lebih fokus --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight hidden">
            Pesanan Berhasil
        </h2>
    </x-slot>

    <div class="py-12 bg-white">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 text-center">

            {{-- Ikon Sukses Animasi --}}
            <div class="w-24 h-24 bg-green-100 rounded-full p-2 flex items-center justify-center mx-auto">
                <div class="w-20 h-20 bg-green-200 rounded-full p-2 flex items-center justify-center">
                    {{-- Ikon Checkmark --}}
                    <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>

            {{-- Judul dan Subjudul --}}
            <h1 class="mt-6 text-3xl font-extrabold text-slate-900">Pesanan Berhasil Dibuat!</h1>
            <p class="mt-2 text-slate-600">Terima kasih telah mempercayai SpeedBox. Driver kami akan segera menuju
                lokasi penjemputan.</p>

            {{-- Kartu Ringkasan Pesanan --}}
            <div class="mt-8 bg-white rounded-2xl shadow-lg text-left p-6 space-y-4">
                <h3 class="text-lg font-bold border-b pb-3">Ringkasan Pesanan</h3>

                {{-- Detail Driver --}}
                <div class="flex items-center space-x-4">
                    <img class="h-16 w-16 rounded-full object-cover"
                        src="{{ $order->driver->profile_photo_path ? asset('storage/' . $order->driver->profile_photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode($order->driver->name) . '&color=FFFFFF&background=F97316' }}"
                        alt="{{ $order->driver->name }}">
                    <div>
                        <p class="font-bold text-slate-800">{{ $order->driver->name }}</p>
                        <p class="text-sm text-slate-500">{{ $order->driver->driverProfile->vehicleType->name }} -
                            {{ $order->driver->driverProfile->license_plate }}
                        </p>
                    </div>
                </div>

                {{-- Detail Pesanan --}}
                <div class="border-t pt-4 space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-slate-500">ID Pesanan</span>
                        <span class="font-semibold text-slate-800">#{{ $order->id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Tanggal</span>
                        <span class="font-semibold text-slate-800">{{ $order->created_at->format('d F Y, H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Estimasi Jarak</span>
                        <span class="font-semibold text-slate-800">{{ number_format($order->distance_km, 1) }} km</span>
                    </div>
                    <div class="flex justify-between text-base font-bold">
                        <span class="text-slate-800">Total Pembayaran</span>
                        <span class="text-orange-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="mt-8 flex flex-col sm:flex-row justify-center items-center gap-4">
                <a href="{{ route('orders.track', $order->id) }}"
                    class="w-full sm:w-auto inline-block px-8 py-3 bg-orange-500 text-white font-bold rounded-lg shadow-md hover:bg-orange-600 transition transform hover:scale-105 duration-300">
                    Lacak Pesanan Sekarang
                </a>
                <a href="{{ route('dashboard') }}"
                    class="w-full sm:w-auto inline-block px-8 py-3 text-slate-600 font-semibold hover:text-orange-500 transition duration-300">
                    Kembali ke Dashboard
                </a>
            </div>

        </div>
    </div>
</x-app-layout>