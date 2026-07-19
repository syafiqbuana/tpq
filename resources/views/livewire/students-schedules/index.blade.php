<x-layouts.app>
    <div class="flex flex-col gap-2 lg:gap-3">
        <h1 class="text-black text-2xl font-semibold ">{{ request()->route()->defaults['title'] }}</h1>
                <flux:text class="text-md">Informasi jadwal anak berdasarkan hari dan waktu yang telah ditetapkan.</flux:text>
        <livewire:components.schedule-list />
    </div>
</x-layouts.app>
