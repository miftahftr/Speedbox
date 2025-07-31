<x-app-layout>
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

      <div class="flex items-center">
        <h2 class="font-semibold text-3xl text-gray-800 leading-tight mb-8">
          {{ __('Riwayat Tugas Anda') }}
        </h2>
      </div>
      <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
        <div class="p-6 text-gray-900">

          {{-- Navigasi Tab Filter --}}
          <div class="border-b border-gray-200 mb-6">
            <nav class="-mb-px flex space-x-6" aria-label="Tabs">
              <a href="{{ route('driver.history') }}"
                class="shrink-0 border-b-2 px-1 pb-4 text-sm font-medium {{ !request('status') ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                Semua
              </a>
              <a href="{{ route('driver.history', ['status' => 'completed']) }}"
                class="shrink-0 border-b-2 px-1 pb-4 text-sm font-medium {{ request('status') == 'completed' ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                Selesai
              </a>
              <a href="{{ route('driver.history', ['status' => 'cancelled']) }}"
                class="shrink-0 border-b-2 px-1 pb-4 text-sm font-medium {{ request('status') == 'cancelled' ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                Dibatalkan
              </a>
            </nav>
          </div>

          {{-- Daftar Kartu Riwayat --}}
          <div class="space-y-4">
            @forelse ($orders as $order)
          <div
            class="border rounded-lg p-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex-grow w-3/5">
            <div class="flex items-center justify-between">
              <p class="font-bold text-slate-800">Pesanan #{{ $order->id }}</p>
            </div>
            <p class="text-sm text-gray-500 mt-1">Customer: {{ $order->customer->name }}</p>
            <p class="text-sm text-gray-500">{{ $order->created_at->format('d F Y') }}</p>
            </div>

            <div class="w-1/5 flex justify-end items-center">
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
          @if($order->status == 'completed') bg-green-100 text-green-800 @endif
          @if($order->status == 'cancelled') bg-red-100 text-red-800 @endif
          ">
              {{ ucfirst($order->status) }}
            </span>
            </div>

            <div class="w-1/5 flex flex-col items-center sm:text-right">
            @if($order->status == 'completed')
            <p class="font-bold text-lg text-green-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
            <div class="flex items-center justify-end mt-1">
            @if ($order->rating)
            @for ($i = 1; $i <= 5; $i++)
          <svg class="w-4 h-4 @if($i <= $order->rating->rating) text-yellow-400 @else text-gray-300 @endif"
          fill="currentColor" viewBox="0 0 20 20">
          <path
            d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
          </svg>
          @endfor
          @else
          <span class="text-xs text-gray-400">Belum ada ulasan</span>
          @endif
            </div>
        @else
          <p class="font-semibold text-red-600">Dibatalkan</p>
        @endif
            </div>
          </div>
      @empty
        <div class="text-center py-12">
          <p class="text-gray-500">Tidak ada riwayat pesanan dengan status ini.</p>
        </div>
      @endforelse
          </div>

          {{-- Paginasi --}}
          <div class="mt-6">
            {{ $orders->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>