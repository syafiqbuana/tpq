<flux:card class="w-full flex flex-col rounded-2xl p-0 m-0  overflow-hidden shadow-sm">
    <div class="w-full p-4 border-b border-slate-200">
        <div class="flex items-center gap-2">
            <span class="text-[16px] text-black">Jadwal berikutnya</span>
        </div>
    </div>
    @if (empty($upcomingSchedules))
        <div class="p-3 flex justify-center items-center px-4">
            <div
                class="flex lg:w-full min-h-37.5 lg:min-h-[200px] flex-col items-center text-center bg-zinc-50 py-4 px-2 rounded-lg border border-zinc-200 gap-3">
                <x-heroicon-o-calendar-date-range
                    class="h-10 w-10 bg-zinc-100 rounded-full border border-zinc-200 px-2 py-2" />
                <p class="text-sm font-semibold text-zinc-900">
                    Tidak Ada Jadwal
                </p>
                <p class="text-sm text-zinc-600">
                    Silakan kembali besok atau cek menu <span class="font-medium">Jadwal</span> untuk melihat jadwal.
                </p>

                <flux:button wire:navigate variant="primary" size="xs" class="md:px-5 md:py-2 md:text-sm">
                    Halaman Jadwal
                </flux:button>
            </div>
        </div>
    @else
        <div x-data="{
            current: 0,
            total: {{ count($upcomingSchedules) }},
            timer: null,
            touchStartX: 0,
        
            init() {
                if (this.total > 1) this.startAuto();
            },
            startAuto() {
                this.timer = setInterval(() => this.next(), 4000);
            },
            stopAuto() {
                clearInterval(this.timer);
            },
            prev() {
                this.stopAuto();
                this.current = (this.current - 1 + this.total) % this.total;
                this.startAuto();
            },
            next() {
                this.current = (this.current + 1) % this.total;
            },
            goTo(i) {
                this.stopAuto();
                this.current = i;
                this.startAuto();
            },
            onTouchStart(e) {
                this.touchStartX = e.changedTouches[0].screenX;
            },
            onTouchEnd(e) {
                const diff = this.touchStartX - e.changedTouches[0].screenX;
                if (Math.abs(diff) > 50) {
                    diff > 0 ? this.next() : this.prev();
                }
            },
        }" x-init="init()">
            {{-- Header --}}
            <div class="w-full bg-amber-50 rounded-t-md p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <x-heroicon-o-clock class="h-7 w-7 text-yellow-800" />
                        <span class="font-semibold text-[18px] text-yellow-800">Jadwal berikutnya</span>
                    </div>

                    {{-- Dots: hanya tampil jika > 1 card --}}
                    @if (count($upcomingSchedules) > 1)
                        <div class="flex items-center gap-1.5">
                            @foreach ($upcomingSchedules as $i => $_)
                                <button @click="goTo({{ $i }})"
                                    :class="current === {{ $i }} ?
                                        'w-4 bg-yellow-800' :
                                        'w-2 bg-yellow-300'"
                                    class="h-2 rounded-full transition-all duration-300"></button>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- Slides --}}
            <div class="relative grid" @touchstart="onTouchStart($event)" @touchend="onTouchEnd($event)">
                @foreach ($upcomingSchedules as $i => $schedule)
                    <div class="col-start-1 row-start-1 p-4 w-full" x-show="current === {{ $i }}"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-x-4"
                        x-transition:enter-end="opacity-100 translate-x-0"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-x-0"
                        x-transition:leave-end="opacity-0 -translate-x-4">
                        <flux:card class="flex flex-col gap-3">
                            <h2 class="text-[20px] font-extrabold">{{ $schedule['name'] }}</h2>

                            <div class="flex flex-col gap-3">
                                <div class="flex items-center gap-3">
                                    <x-heroicon-o-calendar class="w-5 h-5 text-slate-500 shrink-0" />
                                    <flux:text class="text-base text-slate-500">
                                        {{ $schedule['next_day'] }}, {{ $schedule['next_date'] }}
                                    </flux:text>
                                </div>
                                <div class="flex items-center gap-3">
                                    <x-heroicon-o-clock class="w-5 h-5 text-slate-500 shrink-0" />
                                    <flux:text class="text-base text-slate-500">
                                        {{ $schedule['time_open'] }} – {{ $schedule['time_close'] }} WIB
                                    </flux:text>
                                </div>
                                <div class="flex items-center gap-3">
                                    <x-heroicon-o-user class="w-5 h-5 text-slate-500 shrink-0" />
                                    <flux:text class="text-base text-slate-500">
                                        {{ $schedule['student_names'] }}
                                    </flux:text>
                                </div>
                            </div>
                        </flux:card>
                    </div>
                @endforeach

                {{-- Tombol prev/next manual --}}
                @if (count($upcomingSchedules) > 1)
                    <button @click="prev()"
                        class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white shadow rounded-full p-1 transition z-10">
                        <x-heroicon-o-chevron-left class="w-5 h-5 text-slate-600" />
                    </button>
                    <button @click="next()"
                        class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white shadow rounded-full p-1 transition z-10">
                        <x-heroicon-o-chevron-right class="w-5 h-5 text-slate-600" />
                    </button>
                @endif
            </div>

        </div>
    @endif

</flux:card>
