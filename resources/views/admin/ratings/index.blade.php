<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex items-center">
                <h2 class="font-semibold text-3xl text-gray-800 leading-tight mb-10">
                    {{ __('Monitor Rating Driver') }}
                </h2>
            </div>
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-6">

                    {{-- Header: Judul dan Search Bar --}}
                    <div class="flex flex-col sm:flex-row justify-between items-center">
                        <h3 class="text-xl font-bold text-slate-800 mb-4 sm:mb-0">Daftar Rating Driver</h3>
                        <div class="w-full sm:w-auto">
                            <form method="GET" action="{{ route('admin.ratings.index') }}" class="flex-grow">
                                <input type="text" name="search" placeholder="Cari nama driver..."
                                    value="{{ request('search') }}"
                                    class="w-full sm:w-64 px-4 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            </form>
                        </div>
                    </div>

                    {{-- Tabel Rating --}}
                    <div class="overflow-x-auto border rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Driver</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Total Ulasan</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Rata-rata Rating</th>
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
                                            {{ $driver->driver_ratings_count }} ulasan
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <span
                                                    class="mr-2 font-bold text-slate-700">{{ number_format($driver->driver_ratings_avg_rating, 1) }}</span>
                                                @if($driver->driver_ratings_count > 0)
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <svg class="w-5 h-5 @if($i <= round($driver->driver_ratings_avg_rating)) text-yellow-400 @else text-gray-300 @endif"
                                                            fill="currentColor" viewBox="0 0 20 20">
                                                            <path
                                                                d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                                        </svg>
                                                    @endfor
                                                @else
                                                    <span class="text-xs text-gray-400">Belum ada rating</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">
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
    </div>
</x-app-layout>