<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpeedBox - Layanan Antar Barang & Pindahan Terpercaya</title>
    <link rel="icon"
        href="https://raw.githubusercontent.com/ain3ko/imgall/refs/heads/main/speedbox%20box%20-%20dark-1.png">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-slate-800">

    {{-- Header & Navigasi (Tidak ada perubahan) --}}
    <header x-data="{ open: false, showNav: true, lastScrollY: window.scrollY }" @scroll.window="
            if (window.scrollY > lastScrollY && window.scrollY > 100) {
                showNav = false; // Scroll ke bawah
            } else {
                showNav = true; // Scroll ke atas
            }
            lastScrollY = window.scrollY;
        " :class="{ '-translate-y-full': !showNav }"
        class="bg-white/80 backdrop-blur-md fixed top-0 left-0 right-0 z-50 shadow-sm transition-transform duration-300">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <a href="#" class="text-2xl font-bold text-orange-500">SpeedBox</a>
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="#layanan" class="text-slate-600 hover:text-orange-500 transition duration-300">Layanan</a>
                    <a href="#fitur" class="text-slate-600 hover:text-orange-500 transition duration-300">Fitur</a>
                    <a href="#testimoni"
                        class="text-slate-600 hover:text-orange-500 transition duration-300">Testimoni</a>
                </nav>
                <div class="hidden md:flex items-center space-x-4">
                    <a href="{{ route('login') }}"
                        class="px-5 py-2 text-slate-600 hover:text-orange-500 font-semibold transition duration-300">Login</a>
                    <a href="{{ route('register') }}"
                        class="px-5 py-2 bg-orange-500 text-white font-semibold rounded-lg shadow-md hover:bg-orange-600 transition duration-300 transform hover:scale-105">Daftar</a>
                </div>
                <div class="md:hidden">
                    <button @click="open = !open">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <div x-show="open" @click.away="open = false" class="md:hidden mt-4 space-y-2">
                <a href="#layanan" class="block px-4 py-2 text-slate-600 hover:bg-orange-50 rounded-lg">Layanan</a>
                <a href="#fitur" class="block px-4 py-2 text-slate-600 hover:bg-orange-50 rounded-lg">Fitur</a>
                <a href="#testimoni" class="block px-4 py-2 text-slate-600 hover:bg-orange-50 rounded-lg">Testimoni</a>
                <div class="pt-4 border-t border-slate-200 space-y-2">
                    <a href="{{ route('register') }}"
                        class="block text-center w-full px-5 py-2 bg-orange-500 text-white font-semibold rounded-lg shadow-md hover:bg-orange-600">Daftar</a>
                    <a href="{{ route('login') }}"
                        class="block text-center w-full px-5 py-2 text-slate-600 font-semibold">Login</a>
                </div>
            </div>
        </div>
    </header>

    <main>
        {{-- Hero Section --}}
        {{-- PERUBAHAN: Ditambahkan min-h-screen, flex, items-center --}}
        <section class="min-h-screen flex items-center pt-20 md:pt-24">
            <div class="container mx-auto px-6 opacity-0 animate-fade-in-up">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    {{-- Teks Hero --}}
                    <div class="text-center md:text-left">
                        <span class="text-orange-500 font-semibold">Solusi Pindahan Tanpa Ribet</span>
                        <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 mt-2 mb-6 leading-tight">
                            ANTAR BARANG & PINDAHAN JADI LEBIH MUDAH BERSAMA SPEEDBOX
                        </h1>
                        <p class="text-lg text-slate-600 mb-8">
                            Mau kirim paket, dokumen, atau barang berukuran besar? Kami siap jemput dan antar secepat
                            kilat. Dengan armada lengkap
                            dan driver profesional, semua pesananmu dijamin sampai tujuan dengan aman
                        </p>
                        <a href="{{ route('register') }}"
                            class="inline-block px-8 py-4 bg-orange-500 text-white font-bold rounded-xl shadow-lg hover:bg-orange-600 transition duration-300 transform hover:scale-105">
                            Pesan Sekarang
                        </a>
                    </div>
                    {{-- Gambar Hero --}}
                    <div class="relative justify-items-center md:justify-items-end">
                        <div
                            class="absolute -top-8 -left-8 w-48 h-48 bg-orange-100 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob">
                        </div>
                        <div
                            class="absolute -bottom-8 -right-8 w-48 h-48 bg-orange-100 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000">
                        </div>
                        <img src="https://raw.githubusercontent.com/ain3ko/imgall/refs/heads/main/E-6IV.jpg"
                            alt="Layanan Pindahan SpeedBox"
                            class="max-w-[550px] w-full rounded-2xl shadow-2xl relative z-8">
                    </div>
                </div>
            </div>
        </section>

        {{-- Body: Sub Section Penjelasan Layanan --}}
        {{-- PERUBAHAN: Ditambahkan min-h-screen, flex, flex-col, justify-center dan padding diubah --}}
        <section id="layanan" class="min-h-screen bg-orange-100 flex flex-col justify-center py-16 md:py-20">
            <div class="container mx-auto px-6 text-center opacity-0 animate-fade-in-up">
                <h2 class="text-3xl font-bold mb-4">Layanan Andalan Kami</h2>
                <p class="max-w-2xl mx-auto text-slate-600 mb-12">Pilih jenis layanan yang paling sesuai dengan
                    kebutuhan pengiriman atau pindahan Anda.</p>
                <div class="grid md:grid-cols-3 gap-8">
                    {{-- Card Layanan 1 --}}
                    <div
                        class="bg-orange-500 p-8 rounded-xl shadow-lg hover:shadow-2xl transition duration-300 transform hover:-translate-y-2">
                        <div
                            class="bg-white text-orange-500 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2 text-white">Pindahan Rumah</h3>
                        <p class="text-white">Kami menyediakan layanan pindahan rumah yang terencana dan efisien. Dengan
                            tim berpengalaman dan armada yang andal, kami
                            pastikan semua perabotan dan barang berharga Anda sampai di tujuan dengan selamat dan tepat
                            waktu.</p>
                    </div>
                    {{-- Card Layanan 2 --}}
                    <div
                        class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition duration-300 transform hover:-translate-y-2">
                        <div
                            class="bg-orange-100 text-orange-500 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Pindahan Kantor</h3>
                        <p class="text-slate-600">Percayakan relokasi kantor Anda pada ahlinya. Kami menangani setiap
                            detail, mulai dari perencanaan, pembongkaran, hingga
                            instalasi kembali di lokasi baru, dengan keamanan dan kerahasiaan aset bisnis yang terjamin.
                        </p>
                    </div>
                    {{-- Card Layanan 3 --}}
                    <div
                        class="bg-orange-500 p-8 rounded-xl shadow-lg hover:shadow-2xl transition duration-300 transform hover:-translate-y-2">
                        <div
                            class="bg-white text-orange-500 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2 text-white">Antar Barang</h3>
                        <p class="text-white">Dari satu sofa hingga logistik untuk bisnis Anda, layanan antar barang
                            kami solusinya. Dengan pilihan armada yang
                            beragam, kami memastikan pengiriman barang Anda, besar maupun kecil, berjalan lancar dan
                            efisien.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Body: Sub Section Fitur Unggulan --}}
        {{-- PERUBAHAN: Ditambahkan min-h-screen, flex, flex-col, justify-center dan padding diubah --}}
        <section id="fitur" class="min-h-screen flex flex-col justify-center py-16 md:py-20">
            <div class="container mx-auto px-6 opacity-0 animate-fade-in-up">
                <div class="text-center mb-32">
                    <h2 class="text-3xl font-bold mb-4">Kenapa Memilih SpeedBox?</h2>
                    <p class="max-w-2xl mx-auto text-slate-600">Fitur-fitur kami dirancang untuk memberikan Anda
                        ketenangan dan kemudahan dalam setiap pengiriman.</p>
                </div>
                {{-- Fitur 1 --}}
                <div class="grid md:grid-cols-2 gap-12 items-center mb-16">
                    <img src="https://raw.githubusercontent.com/ain3ko/imgall/refs/heads/main/E-6-V.jpeg"
                        alt="Live Tracking" class="max-w-[570px] w-full rounded-2xl shadow-2xl relative z-8">
                    <div>
                        <h3 class="text-2xl font-bold mb-4">Lacak Pengiriman Secara Real-time</h3>
                        <p class="text-slate-600 mb-6">Tak perlu cemas! Pantau posisi driver dan barang Anda secara
                            langsung dari awal penjemputan hingga tiba di tujuan melalui peta interaktif kami.</p>
                        {{-- ... (list fitur) ... --}}
                    </div>
                </div>
                {{-- Fitur 2 --}}
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div class="md:order-2">
                        <img src="https://raw.githubusercontent.com/ain3ko/imgall/refs/heads/main/E-6-VI.png"
                            alt="Harga Transparan" class="max-w-[570px] w-full rounded-2xl shadow-2xl relative z-8">
                    </div>
                    <div class="md:order-1">
                        <h3 class="text-2xl font-bold mb-4">Harga Pasti & Transparan</h3>
                        <p class="text-slate-600 mb-6">Hitung estimasi biaya langsung di aplikasi sebelum memesan. Tidak
                            ada biaya tersembunyi, harga ditentukan di awal berdasarkan jarak dan jenis kendaraan.</p>
                        {{-- ... (list fitur) ... --}}
                    </div>
                </div>
            </div>
        </section>

        {{-- Body: Sub Section Testimoni --}}
        {{-- PERUBAHAN: Ditambahkan min-h-screen, flex, flex-col, justify-center dan padding diubah --}}
        <section id="testimoni" class="min-h-screen bg-orange-100 flex flex-col justify-center py-16 md:py-20">
            <div class="container mx-auto px-6 text-center opacity-0 animate-fade-in-up">
                <h2 class="text-3xl font-bold mb-4">Apa Kata Mereka?</h2>
                <p class="max-w-2xl mx-auto text-slate-600 mb-12">Kepuasan pelanggan adalah prioritas utama kami. Lihat
                    pengalaman mereka menggunakan SpeedBox.</p>
                <div class="grid md:grid-cols-3 gap-8">
                    {{-- Card Testimoni 1 --}}
                    <div class="bg-white p-8 rounded-xl shadow-lg text-left">
                        <div class="flex items-center mb-4">
                            <img src="https://i.pravatar.cc/150?u=a042581f4e29026704d" alt="Pelanggan 1"
                                class="w-12 h-12 rounded-full mr-4">
                            <div>
                                <p class="font-semibold">Ahmad Subarjo</p>
                                <p class="text-sm text-slate-500">Pengusaha</p>
                            </div>
                        </div>
                        <p class="text-slate-600 italic">"Pindahan kantor jadi lancar jaya! Drivernya profesional dan
                            tepat waktu. Fitur trackingnya sangat membantu. Recommended!"</p>
                    </div>
                    {{-- Card Testimoni 2 --}}
                    <div class="bg-white p-8 rounded-xl shadow-lg text-left">
                        <div class="flex items-center mb-4">
                            <img src="https://i.pravatar.cc/150?u=a042581f4e29026704e" alt="Pelanggan 2"
                                class="w-12 h-12 rounded-full mr-4">
                            <div>
                                <p class="font-semibold">Citra Lestari</p>
                                <p class="text-sm text-slate-500">Mahasiswa</p>
                            </div>
                        </div>
                        <p class="text-slate-600 italic">"Buat pindahan kosan oke banget. Harganya ramah di kantong,
                            proses pesannya juga gampang. Gak pake ribet sama sekali."</p>
                    </div>
                    {{-- Card Testimoni 3 --}}
                    <div class="bg-white p-8 rounded-xl shadow-lg text-left">
                        <div class="flex items-center mb-4">
                            <img src="https://i.pravatar.cc/150?u=a042581f4e29026704f" alt="Pelanggan 3"
                                class="w-12 h-12 rounded-full mr-4">
                            <div>
                                <p class="font-semibold">Budi Santoso</p>
                                <p class="text-sm text-slate-500">Keluarga Baru</p>
                            </div>
                        </div>
                        <p class="text-slate-600 italic">"Awalnya ragu, tapi ternyata pelayanannya memuaskan.
                            Barang-barang pindahan rumah aman sampai tujuan. Terima kasih SpeedBox!"</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Body: Sub Section Penawaran Khusus (CTA) --}}
        {{-- PERUBAHAN: Ditambahkan min-h-screen, flex, flex-col, justify-center dan padding diubah --}}
        <section class="min-h-screen bg-orange-500 text-white flex flex-col justify-center py-16 md:py-20">
            <div class="container mx-auto px-6 text-center opacity-0 animate-fade-in-up">
                <h2 class="text-3xl md:text-4xl font-extrabold mb-4">Siap untuk Pindahan Tanpa Stres?</h2>
                <p class="max-w-2xl mx-auto text-orange-100 mb-8">Daftar sekarang dan nikmati kemudahan mengirim barang
                    atau pindahan di ujung jari Anda.</p>
                <a href="{{ route('register') }}"
                    class="inline-block px-10 py-4 bg-white text-orange-500 font-bold rounded-xl shadow-lg hover:bg-orange-50 transition duration-300 transform hover:scale-105">
                    Mulai Sekarang
                </a>
            </div>
        </section>
    </main>

    {{-- Footer --}}
    <footer class="bg-slate-800 text-slate-300">
        <div class="container mx-auto px-6 py-12">
            <div class="grid md:grid-cols-4 gap-8">
                {{-- Kolom 1 --}}
                <div class="md:col-span-2">
                    <h4 class="text-xl font-bold text-white mb-4">SpeedBox</h4>
                    <p class="max-w-md">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam et justo et ex
                        rhoncus viverra. Sed eu laoreet ex.</p>
                </div>
                {{-- Kolom 2 --}}
                <div>
                    <h4 class="font-semibold text-white mb-4">Navigasi</h4>
                    <ul class="space-y-2">
                        <li><a href="#layanan" class="hover:text-orange-400">Layanan</a></li>
                        <li><a href="#fitur" class="hover:text-orange-400">Fitur</a></li>
                        <li><a href="#testimoni" class="hover:text-orange-400">Testimoni</a></li>
                    </ul>
                </div>
                {{-- Kolom 3 --}}
                <div>
                    <h4 class="font-semibold text-white mb-4">Ikuti Kami</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="hover:text-orange-400">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M22.46,6C21.69,6.35 20.86,6.58 20,6.69C20.88,6.16 21.56,5.32 21.88,4.31C21.05,4.81 20.13,5.16 19.16,5.36C18.37,4.5 17.26,4 16,4C13.65,4 11.73,5.92 11.73,8.29C11.73,8.63 11.77,8.96 11.84,9.27C8.28,9.09 5.11,7.38 2.98,4.79C2.63,5.42 2.42,6.16 2.42,6.94C2.42,8.43 3.17,9.75 4.33,10.5C3.62,10.5 2.96,10.3 2.38,10C2.38,10 2.38,10 2.38,10.03C2.38,12.11 3.86,13.85 5.82,14.24C5.46,14.34 5.08,14.39 4.69,14.39C4.42,14.39 4.15,14.36 3.89,14.31C4.43,16.03 6.02,17.25 7.89,17.29C6.43,18.45 4.58,19.13 2.56,19.13C2.22,19.13 1.88,19.11 1.54,19.07C3.44,20.29 5.7,21 8.12,21C16,21 20.33,14.46 20.33,8.84C20.33,8.63 20.33,8.42 20.32,8.21C21.17,7.63 21.88,6.87 22.46,6Z">
                                </path>
                            </svg>
                        </a>
                        <a href="#" class="hover:text-orange-400">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12,2.04C6.5,2.04 2.04,6.5 2.04,12C2.04,17.5 6.5,21.96 12,21.96C17.5,21.96 21.96,17.5 21.96,12C21.96,6.5 17.5,2.04 12,2.04M12,20C7.59,20 4,16.41 4,12C4,7.59 7.59,4 12,4C16.41,4 20,7.59 20,12C20,16.41 16.41,20 12,20M12,8A4,4 0 0,0 8,12A4,4 0 0,0 12,16A4,4 0 0,0 16,12A4,4 0 0,0 12,8M12,14A2,2 0 0,1 10,12A2,2 0 0,1 12,10A2,2 0 0,1 14,12A2,2 0 0,1 12,14M16.5,6.5A1.5,1.5 0 0,0 15,8A1.5,1.5 0 0,0 16.5,9.5A1.5,1.5 0 0,0 18,8A1.5,1.5 0 0,0 16.5,6.5Z">
                                </path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-8 border-t border-slate-700 text-center text-sm">
                <p>&copy; {{ date('Y') }} SpeedBox. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>

</html>