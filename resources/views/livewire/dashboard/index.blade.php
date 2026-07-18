<x-layouts.app>
    <div class="flex flex-col gap-2 lg:gap-3">
        <h1 class="text-black text-2xl font-semibold ">Selamat Datang, {{ auth()->user()->name }}!</h1>
        <flux:text class="text-lg">Pantau kegiatan anak anda</flux:text>
        <livewire:components.stat-overview />
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-2">
            <livewire:components.upcoming-schedules />
            <livewire:components.attendance-today-widget />
        </div>
    </div>
</x-layouts.app>
