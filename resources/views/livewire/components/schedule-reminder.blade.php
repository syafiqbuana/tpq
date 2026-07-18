<div>
    {{-- Pastikan variabel $todaySchedule tidak kosong --}}
    @if($todaySchedule)
        <div class="flex items-start gap-3 rounded-2xl border border-blue-100 bg-blue-50 p-5 shadow-sm min-h-25 ">
            {{-- Ikon Lonceng (Heroicons) --}}
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-100">
                <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                </svg>
            </div>
            
            {{-- Teks Reminder --}}
            <div class="pt-0.5">
                <h4 class="text-sm font-semibold text-blue-900">Jadwal Hari Ini</h4>
                
                {{-- Looping array $todaySchedule --}}
                <div class="mt-1 flex flex-col gap-1">
                    @foreach($todaySchedule as $schedule)
                        <p class="text-sm text-blue-700">
                          {{ $loop->iteration }}. {{ $schedule }}
                        </p>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>