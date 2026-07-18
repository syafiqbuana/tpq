<x-layouts.app>
    <!-- Layout Container (Tampilan Mobile Vertikal Penuh) -->
<div class="max-w-md mx-auto bg-gray-50 min-h-screen flex flex-col font-sans">
    
    <!-- Top Bar -->
    <div class="bg-white px-5 py-4 border-b border-gray-100 flex items-center justify-between sticky top-0 z-10">
        <div class="flex items-center gap-3">
            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
            <h1 class="text-lg font-semibold text-gray-800">Jadwal Anak</h1>
        </div>
        <div class="text-sm text-gray-500">18 Juli</div>
    </div>

    <!-- Filter Section (Dropdown) -->
    <div class="px-5 pt-5 pb-2">
        <div class="relative">
            <select class="w-full bg-white border border-gray-200 text-gray-700 py-3 px-4 rounded-xl appearance-none focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent font-medium shadow-sm transition-all">
                <option value="all">Semua Anak</option>
                <option value="1">Murid 1</option>
                <option value="32">murid 2</option>
            </select>
            <!-- Custom Dropdown Arrow -->
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </div>
        </div>
    </div>

    <!-- Content Area (Card List) -->
    <div class="flex-1 px-5 py-4 space-y-4">
        
        <!-- Kartu Jadwal 1 -->
        <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm relative overflow-hidden">
            <div class="absolute top-0 left-0 w-1.5 h-full bg-purple-500"></div>
            
            <div class="flex justify-between items-start mb-3">
                <div>
                    <h2 class="text-base font-bold text-gray-800">Jadwal Pagi Rerum</h2>
                    <p class="text-sm text-gray-500 mt-0.5">Kelas Pemula</p>
                </div>
                <span class="inline-flex items-center justify-center px-2.5 py-1 text-xs font-semibold text-purple-700 bg-purple-100 rounded-full">
                    Senin, Rabu
                </span>
            </div>

            <div class="space-y-2 mt-4">
                <div class="flex items-center text-sm text-gray-700">
                    <svg class="w-4 h-4 mr-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <span class="font-medium">Murid 1</span>
                </div>
                <div class="flex items-center text-sm text-gray-700">
                    <svg class="w-4 h-4 mr-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>09:46 - 11:00</span>
                </div>
            </div>
        </div>

        <!-- Kartu Jadwal 2 -->
        <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm relative overflow-hidden">
            <div class="absolute top-0 left-0 w-1.5 h-full bg-blue-500"></div>
            
            <div class="flex justify-between items-start mb-3">
                <div>
                    <h2 class="text-base font-bold text-gray-800">Jadwal Pagi Quo</h2>
                    <p class="text-sm text-gray-500 mt-0.5">Kelas Pemula</p>
                </div>
                <span class="inline-flex items-center justify-center px-2.5 py-1 text-xs font-semibold text-blue-700 bg-blue-100 rounded-full">
                    Selasa, Kamis
                </span>
            </div>

            <div class="space-y-2 mt-4">
                <div class="flex items-center text-sm text-gray-700">
                    <svg class="w-4 h-4 mr-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <span class="font-medium">murid 2</span>
                </div>
                <div class="flex items-center text-sm text-gray-700">
                    <svg class="w-4 h-4 mr-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>08:13 - 10:12</span>
                </div>
            </div>
        </div>

    </div>
</div>
</x-layouts.app>
