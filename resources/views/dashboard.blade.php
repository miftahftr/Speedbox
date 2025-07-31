<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex items-center">
                <h2 class="font-semibold text-3xl text-gray-800 leading-tight mb-8">
                    {{ __('Dashboard') }}
                </h2>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Kolom Kiri: Kartu Aksi Utama --}}
                <div class="lg:col-span-2">
                    <div
                        class="flex flex-col justify-center h-full bg-gradient-to-br from-orange-500 to-orange-600 p-8 rounded-xl shadow-lg text-white">
                        <h3 class="text-3xl font-bold">Halo, {{ Auth::user()->name }}!</h3>
                        <p class="mt-2 text-orange-100 max-w-lg">Siap untuk mengirim barang atau pindahan? Mulai
                            petualangan Anda dengan SpeedBox sekarang.</p>
                        <a href="{{ route('orders.create') }}"
                            class="w-60 mt-6 inline-block px-8 py-3 bg-white text-orange-600 font-bold rounded-lg shadow-md hover:bg-orange-50 transition transform hover:scale-105 duration-300">
                            Buat Pesanan Baru
                        </a>
                    </div>
                </div>

                {{-- Kolom Kanan: Info Cepat --}}
                <div class="space-y-6">
                    {{-- Kartu Pesanan Terakhir --}}
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h4 class="font-bold text-slate-800 mb-3">Pesanan Terakhir Anda</h4>
                        @if($latestOrder)
                            <div>
                                <div class="flex justify-between items-center">
                                    <p class="text-sm text-slate-500">Pesanan #{{ $latestOrder->id }}</p>
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                                                @if($latestOrder->status == 'completed') bg-green-100 text-green-800 @endif
                                                                                @if($latestOrder->status == 'cancelled') bg-red-100 text-red-800 @endif
                                                                                @if($latestOrder->status != 'completed' && $latestOrder->status != 'cancelled') bg-blue-100 text-blue-800 @endif">
                                        {{ ucfirst($latestOrder->status) }}
                                    </span>
                                </div>
                                <p class="mt-2 font-semibold">Rp {{ number_format($latestOrder->total_price, 0, ',', '.') }}
                                </p>

                                {{-- Tombol Lacak hanya muncul jika pesanan aktif --}}
                                @if ($latestOrder->status == 'paid' || $latestOrder->status == 'on_duty')
                                    <a href="{{ route('orders.track', $latestOrder->id) }}"
                                        class="mt-4 inline-block w-full text-center px-4 py-2 bg-indigo-100 text-indigo-700 text-sm font-semibold rounded-lg hover:bg-indigo-200">
                                        Lacak Pesanan
                                    </a>
                                @endif
                            </div>
                        @else
                            <p class="text-sm text-slate-500">Anda belum pernah membuat pesanan.</p>
                        @endif
                    </div>

                    {{-- Kartu Statistik & Navigasi Cepat --}}
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <div class="flex items-center space-x-4 mb-4 pb-4 border-b">
                            <div class="bg-green-100 p-3 rounded-full">
                                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Pesanan Selesai</p>
                                <p class="text-xl font-bold">{{ $completedOrdersCount }}</p>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <a href="{{ route('orders.history') }}"
                                class="block text-slate-600 font-semibold hover:text-orange-600">→ Lihat Riwayat
                                Pesanan</a>
                            <a href="{{ route('profile.edit') }}"
                                class="block text-slate-600 font-semibold hover:text-orange-600">→ Edit Profil Anda</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>