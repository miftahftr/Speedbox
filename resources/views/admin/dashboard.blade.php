<x-app-layout>
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
      <div class="head-admin flex items-center px-8">
        <h2 class="font-semibold text-3xl text-black leading-tight mb-10">
          {{ __('Admin Dashboard') }}
        </h2>
      </div>
      {{-- Baris 1: 3 Kartu Statistik Kecil --}}
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 justify-items-center ">
        <div class="bg-orange-400 p-6 rounded-lg shadow-md w-5/6 flex">
          <div class="overflow-visible w-2/6">
            <img src="https://raw.githubusercontent.com/ain3ko/imgall/refs/heads/main/kurir.png"
              class=" -mt-12 w-20 h-30">
          </div>
          <div class="text-white ml-2">
            <p class="text-s">Total Pesanan</p>
            <p class="text-3xl font-bold mt-1">{{ $totalOrders }}</p>
          </div>
        </div>
        <div class="bg-orange-400 p-6 rounded-lg shadow-md w-5/6 flex">
          <div class="overflow-visible w-2/6">
            <img src="https://raw.githubusercontent.com/ain3ko/imgall/refs/heads/main/kurir.png"
              class=" -mt-12 w-20 h-30">
          </div>
          <div class="text-white ml-2">
            <p class="text-sm ">Total Customer</p>
            <p class="text-3xl font-bold mt-1">{{ $totalCustomers }}</p>
          </div>
        </div>


        <div class="bg-orange-400 p-6 rounded-lg shadow-md w-5/6 flex">
          <div class="overflow-visible w-2/6">
            <img src="https://raw.githubusercontent.com/ain3ko/imgall/refs/heads/main/kurir.png"
              class=" -mt-12 w-20 h-30">
          </div>
          <div class="text-white ml-2">
            <p class="text-sm ">Driver Aktif</p>
            <p class="text-3xl font-bold mt-1">{{ $activeDrivers }}</p>
          </div>
        </div>
      </div>

      {{-- Baris 2: 1 Kartu Statistik Besar --}}
      <div class="flex justify-center px-8">
        <div class="bg-white p-6 rounded-lg shadow-md w-full">
          <p class="text-sm text-gray-500">Total Pendapatan</p>
          <p class="text-3xl font-bold mt-1 text-green-600">Rp {{ number_format($totalRevenue) }}</p>
        </div>
      </div>


      {{-- Baris 3: Konten Utama (Tabel & Driver Rating) --}}
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 px-8">

        {{-- Kolom Kiri: Tabel Pesanan Terbaru --}}
        <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-md space-y-4">
          <h3 class="font-bold text-lg">Pesanan Terbaru</h3>

          {{-- Kontrol Tabel: Search & Sort --}}
          <form method="GET" action="{{ route('admin.dashboard') }}">
            <div class="flex items-center space-x-4">
              <div class="flex-grow">
                <input type="text" name="search" placeholder="Cari pesanan..." value="{{ request('search') }}"
                  class="w-full sm:w-5/6 px-4 py-2 border border-slate-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
              </div>
              <div>
                <select name="sort" onchange="this.form.submit()"
                  class="w-24 sm:w-40 text-xs sm:text-base px-4 py-2 border border-slate-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                  <option value="newest" @selected(request('sort', 'newest') == 'newest')>Terbaru</option>
                  <option value="oldest" @selected(request('sort') == 'oldest')>Terlama</option>
                </select>
              </div>
            </div>
          </form>

          {{-- Tabel --}}
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 mt-4">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                  <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Driver</th>
                  <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($recentOrders as $order)
              <tr>
                <td class="px-4 py-3 whitespace-nowrap">{{ $order->customer->name }}</td>
                <td class="px-4 py-3 whitespace-nowrap">{{ $order->driver->name }}</td>
                <td class="px-4 py-3 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
            @if($order->status == 'completed') bg-green-100 text-green-800 @endif
            @if($order->status == 'cancelled') bg-red-100 text-red-800 @endif
            @if($order->status != 'completed' && $order->status != 'cancelled') bg-blue-100 text-blue-800 @endif">
                  {{ ucfirst($order->status) }}
                </span>
                </td>
              </tr>
        @empty
          <tr>
            <td colspan="3" class="px-4 py-3 text-center text-gray-500">Belum ada pesanan.</td>
          </tr>
        @endforelse
              </tbody>
            </table>
          </div>
        </div>

        {{-- Kolom Kanan: List Driver Rating Tertinggi --}}
        <div class="lg:col-span-1 bg-white p-6 rounded-lg shadow-md text-black">
          <h3 class="font-bold text-lg mb-4">Driver dengan Rating Tertinggi</h3>
          <ul class="space-y-4">
            @forelse ($topDrivers as $driver)
        <li class="flex items-center space-x-3 bg-white/20 p-3 rounded-lg">
          <img class="h-10 w-10 rounded-full object-cover"
          src="{{ $driver->profile_photo_path ? asset('storage/' . $driver->profile_photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode($driver->name) . '&color=FFFFFF&background=F97316' }}"
          alt="{{ $driver->name }}">
          <div>
          <p class="font-semibold">{{ $driver->name }}</p>
          <div class="flex items-center">
            <span class="text-sm font-bold mr-1">{{ number_format($driver->driver_ratings_avg_rating, 1) }}</span>
            <svg class="w-4 h-4 text-yellow-300" fill="currentColor" viewBox="0 0 20 20">
            <path
              d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
            </svg>
          </div>
          </div>
        </li>
      @empty
        <li class="text-cyan-100">Belum ada driver yang memiliki rating.</li>
      @endforelse
          </ul>
        </div>

      </div>

    </div>
  </div>
</x-app-layout>