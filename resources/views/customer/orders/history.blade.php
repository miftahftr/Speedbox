<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="flex items-center">
                <h2 class="font-semibold text-3xl text-gray-800 leading-tight mb-8">
                    {{ __('Riwayat Pesanan Anda') }}
                </h2>
            </div>
            <div class="space-y-6">

                {{-- Pesan Sukses --}}
                @if(session('success'))
                    <div class="p-4 bg-green-100 text-green-700 border border-green-300 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                @forelse ($orders as $order)
                    {{-- Kartu Pesanan --}}
                    <div class="bg-white overflow-hidden shadow-md rounded-lg">
                        {{-- Header Kartu --}}
                        <div
                            class="p-6 flex flex-col sm:flex-row justify-between items-start sm:items-center bg-gray-50 border-b">
                            <div>
                                <h3 class="text-lg font-bold text-slate-800">Pesanan #{{ $order->id }}</h3>
                                <p class="text-sm text-gray-500">{{ $order->created_at->format('d F Y, H:i') }}</p>
                            </div>
                            <span class="mt-2 sm:mt-0 px-3 py-1 text-sm font-semibold rounded-full 
                                                @if($order->status == 'completed') bg-green-100 text-green-800 @endif
                                                @if($order->status == 'cancelled') bg-red-100 text-red-800 @endif
                                                @if($order->status == 'paid' || $order->status == 'on_the_way') bg-blue-100 text-blue-800 @endif
                                            ">
                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                            </span>
                        </div>

                        {{-- Body Kartu --}}
                        <div class="p-6 space-y-4">
                            <div class="flex items-center space-x-4">
                                <img class="h-12 w-12 rounded-full object-cover"
                                    src="{{ $order->driver->profile_photo_path ? asset('storage/' . $order->driver->profile_photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode($order->driver->name) . '&color=FFFFFF&background=F97316' }}"
                                    alt="{{ $order->driver->name }}">
                                <div>
                                    <p class="font-semibold text-slate-700">Driver Anda</p>
                                    <p class="text-slate-900">{{ $order->driver->name }}</p>
                                </div>
                            </div>
                            <div class="border-t pt-4">
                                <div class="flex justify-between text-base">
                                    <span class="text-slate-600">Total Pembayaran:</span>
                                    <span class="font-bold text-orange-600">Rp
                                        {{ number_format($order->total_price, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Footer Kartu (Aksi) --}}
                        <div class="px-6 pb-6">
                            {{-- Tombol Lacak Pesanan --}}
                            @if ($order->status == 'paid' || $order->status == 'on_the_way')
                                <a href="{{ route('orders.track', $order->id) }}"
                                    class="block w-full text-center px-4 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition duration-300">
                                    Lacak Pengiriman
                                </a>
                            @endif

                            {{-- Tombol Batalkan Pesanan --}}
                            @if ($order->status == 'paid')
                                <form action="{{ route('orders.cancel', $order->id) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?');" class="mt-2">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-center px-4 py-2 bg-transparent text-red-600 text-sm font-semibold rounded-lg hover:bg-red-50 transition duration-300">
                                        Batalkan Pesanan
                                    </button>
                                </form>
                            @endif

                            {{-- Form & Tampilan Rating --}}
                            @if ($order->status == 'completed' && !$order->rating)
                                <div class="mt-4 pt-4 border-t">
                                    <h4 class="font-semibold mb-2 text-slate-700">Beri Ulasan untuk Driver</h4>
                                    <form action="{{ route('ratings.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                                        <div class="rating-stars flex items-center mb-2" data-order-id="{{ $order->id }}">
                                            <span class="mr-3 text-sm text-slate-600">Rating Anda:</span>
                                            <div class="flex">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <label>
                                                        <input type="radio" name="rating" value="{{ $i }}" class="sr-only">
                                                        <svg class="w-6 h-6 text-gray-300 cursor-pointer rating-star"
                                                            data-value="{{ $i }}" fill="currentColor" viewBox="0 0 20 20">
                                                            <path
                                                                d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                                        </svg>
                                                    </label>
                                                @endfor
                                            </div>
                                        </div>
                                        <div>
                                            <textarea name="comment" rows="2" placeholder="Tulis komentar Anda (opsional)..."
                                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500"></textarea>
                                        </div>
                                        <div class="text-right mt-2">
                                            <button type="submit"
                                                class="px-4 py-2 bg-orange-500 text-white text-sm font-semibold rounded-lg hover:bg-orange-600">Kirim
                                                Ulasan</button>
                                        </div>
                                    </form>
                                </div>
                            @elseif ($order->rating)
                                <div class="mt-4 pt-4 border-t">
                                    <h4 class="font-semibold mb-2 text-slate-700">Ulasan Anda</h4>
                                    <div class="flex items-center">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <svg class="w-5 h-5 @if($i <= $order->rating->rating) text-yellow-400 @else text-gray-300 @endif"
                                                fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                            </svg>
                                        @endfor
                                    </div>
                                    @if($order->rating->comment)
                                        <p class="text-sm text-gray-600 mt-2 italic">"{{ $order->rating->comment }}"</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    {{-- Tampilan Jika Tidak Ada Pesanan --}}
                    <div class="text-center py-16">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                        <h3 class="mt-2 text-lg font-medium text-gray-900">Anda Belum Memiliki Riwayat Pesanan</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Mari buat pesanan pertama Anda!
                        </p>
                        <div class="mt-6">
                            <a href="{{ route('orders.create') }}"
                                class="inline-flex items-center px-4 py-2 bg-orange-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-orange-600">
                                Buat Pesanan Baru
                            </a>
                        </div>
                    </div>
                @endforelse

                {{-- Link Paginasi --}}
                <div class="mt-6">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        {{-- Skrip untuk rating bintang interaktif (tidak berubah) --}}
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const ratingContainers = document.querySelectorAll('.rating-stars');
                ratingContainers.forEach(container => {
                    const stars = container.querySelectorAll('.rating-star');
                    const setRating = (value) => {
                        stars.forEach(star => {
                            if (star.getAttribute('data-value') <= value) {
                                star.classList.add('text-yellow-400');
                                star.classList.remove('text-gray-300');
                            } else {
                                star.classList.add('text-gray-300');
                                star.classList.remove('text-yellow-400');
                            }
                        });
                    };
                    stars.forEach(star => {
                        star.addEventListener('mouseover', () => { setRating(star.getAttribute('data-value')); });
                        star.addEventListener('mouseout', () => {
                            const checkedRadio = container.parentElement.querySelector('input[type="radio"]:checked');
                            setRating(checkedRadio ? checkedRadio.value : 0);
                        });
                        star.addEventListener('click', () => {
                            container.parentElement.querySelector(`input[value="${star.getAttribute('data-value')}"]`).checked = true;
                        });
                    });
                });
            });
        </script>
    @endpush
</x-app-layout>