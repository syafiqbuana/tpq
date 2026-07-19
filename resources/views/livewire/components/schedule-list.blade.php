<!-- 1. Pindahkan x-data kembali ke parent -->
<!-- 2. TAMBAHKAN 'items-start' DI SINI agar card tidak saling tarik ketinggian -->
<div x-data="{ activeAccordion: null }" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 items-start">
    @forelse($schedulesData as $schedule)

        <!-- 3. WAJIB ada wire:key agar state Alpine tidak bocor/tertukar oleh Livewire -->
        <flux:card wire:key="schedule-{{ $schedule['id'] }}" class="flex flex-col gap-4 transition-all duration-300">

            <!-- Header Group -->
            <div class="flex justify-between items-start gap-4">
                <div class="space-y-2 flex-1">
                    <flux:heading size="lg" class="font-semibold leading-tight line-clamp-2">
                        {{ $schedule['name'] }}
                    </flux:heading>

                    <!-- Looping badge nama murid -->
                    <div class="flex flex-wrap gap-2">
                        @foreach ($schedule['student_names'] as $studentName)
                            <flux:badge color="zinc" size="sm" class="flex items-center gap-1 w-max">
                                <flux:icon.user class="w-3 h-3" />
                                {{ $studentName }}
                            </flux:badge>
                        @endforeach
                    </div>
                </div>

                <!-- Tombol Toggle Kalender Akordion (Kembali pakai activeAccordion) -->
                <flux:button variant="subtle" size="sm" class="shrink-0"
                    x-on:click="activeAccordion = activeAccordion === {{ $schedule['id'] }} ? null : {{ $schedule['id'] }}">
                    <div class="flex items-center gap-2">
                        <flux:icon.calendar class="w-4 h-4" />
                        <flux:icon.chevron-down class="w-3 h-3 transition-transform duration-300"
                            x-bind:class="activeAccordion === {{ $schedule['id'] }} ? 'rotate-180' : ''" />
                    </div>
                </flux:button>
            </div>

            <!-- Info Jadwal Waktu & Hari -->
            <div class="space-y-1">
                <div class="flex items-center gap-2">
                    <flux:icon.calendar-days class="w-4 h-4 text-zinc-400" />
                    <flux:text size="sm" class="text-zinc-600 dark:text-zinc-400">
                        {{ $schedule['days_text'] }}
                    </flux:text>
                </div>
                <div class="flex items-center gap-2">
                    <flux:icon.clock class="w-4 h-4 text-zinc-400" />
                    <flux:text size="sm" class="text-zinc-600 dark:text-zinc-400">
                        {{ $schedule['time_text'] }}
                    </flux:text>
                </div>
            </div>

            <!-- Body: Grid Kalender -->
            <div x-show="activeAccordion === {{ $schedule['id'] }}" x-collapse x-cloak>
                <div class="border-t border-zinc-100 dark:border-zinc-800 pt-3 mt-1">

                    <div class="grid grid-cols-7 text-center mb-1">
                        @foreach (['S', 'S', 'R', 'K', 'J', 'S', 'M'] as $dayInitial)
                            <div class="text-[10px] font-medium text-zinc-400">{{ $dayInitial }}</div>
                        @endforeach
                    </div>

                    <div class="grid grid-cols-7 gap-1 text-center">
                        @foreach ($schedule['calendar'] as $calDate)
                            @if ($calDate['date'])
                                @if ($calDate['is_holiday'])
                                    <div title="{{ $calDate['holiday_name'] }}"
                                        class="text-xs aspect-square flex items-center justify-center rounded-md bg-red-100 text-red-600 dark:bg-red-500/20 dark:text-red-400 font-bold cursor-help">
                                        {{ $calDate['date'] }}
                                    </div>
                                @elseif($calDate['is_scheduled'])
                                    <div
                                        class="text-xs aspect-square flex items-center justify-center rounded-md bg-blue-100 text-blue-600 dark:bg-blue-500/20 dark:text-blue-400 font-bold">
                                        {{ $calDate['date'] }}
                                    </div>
                                @else
                                    <div
                                        class="text-xs aspect-square flex items-center justify-center text-zinc-500 dark:text-zinc-500">
                                        {{ $calDate['date'] }}
                                    </div>
                                @endif
                            @else
                                <div></div>
                            @endif
                        @endforeach
                    </div>

                </div>
            </div>

        </flux:card>
    @empty
        <div class="col-span-full">
            <flux:card class="flex flex-col items-center justify-center p-8 text-center text-zinc-500">
                <flux:icon.calendar class="w-8 h-8 mb-2 opacity-50" />
                <flux:text>Belum ada jadwal yang tersedia.</flux:text>
            </flux:card>
        </div>
    @endforelse
</div>
