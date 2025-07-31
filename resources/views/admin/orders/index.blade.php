<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center">
                <h2 class="font-semibold text-3xl text-black leading-tight mb-10">
                    {{ __('Monitor Semua Pesanan') }}
                </h2>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- ================= FORM UNTUK SEARCH & SORT ================= --}}
                    <form method="GET" action="{{ route('admin.orders.index') }}">
                        <div class="flex items-center space-x-4 mb-4">
                            {{-- Input Pencarian --}}
                            <div class="flex-grow">
                                <input type="text" name="search" placeholder="Cari ID, Customer, atau Driver..."
                                    value="{{ request('search') }}"
                                    class="w-4/6 px-4 py-2 border border-slate-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            </div>
                            {{-- Dropdown Sort --}}
                            <div>
                                <select name="sort" onchange="this.form.submit()"
                                    class="px-4 py-2 border border-slate-300 rounded-xl shadow-sm w-28 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                                    <option value="newest" @selected(request('sort', 'newest') == 'newest')>Terbaru
                                    </option>
                                    <option value="oldest" @selected(request('sort') == 'oldest')>Terlama</option>
                                </select>
                            </div>

                        </div>
                    </form>
                    {{-- ================= AKHIR FORM ================= --}}

                    {{-- Tabel Pesanan --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Driver
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total
                                        Harga</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($orders as $order)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">#{{ $order->id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $order->customer->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $order->driver->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($order->total_price) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                                                        @if($order->status == 'completed') bg-green-100 text-green-800 @endif
                                                                                        @if($order->status == 'cancelled') bg-red-100 text-red-800 @endif
                                                                                        @if($order->status != 'completed' && $order->status != 'cancelled') bg-blue-100 text-blue-800 @endif">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $order->created_at->format('d M Y') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                            Tidak ada data pesanan yang cocok dengan pencarian Anda.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Link Paginasi --}}
                    <div class="mt-4">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>