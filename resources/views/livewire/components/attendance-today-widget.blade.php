<flux:card class="shadow-sm rounded-2xl flex flex-col p-0 m-0 overflow-hidden" wire:poll.3m>
    <div class="w-full border-b border-slate-200 p-4">
        <div class="flex items-center gap-2">
            <span class="text-[16px] text-black">Absensi hari ini</span>
        </div>
    </div>

    @php
        // Cek apakah ada minimal 1 anak yang punya jadwal hari ini
        $hasAnySchedule = collect($studentsData)->contains(function ($student) {
            return $student['schedule_name'] !== 'Tidak ada jadwal';
        });
    @endphp

    @if (empty($studentsData))
        <div class="text-zinc-500">Tidak ada data siswa yang terdaftar.</div>
    @elseif($hasAnySchedule)
        <flux:table class="p-3!">
            <flux:table.columns>
                <flux:table.column>Nama</flux:table.column>
                <flux:table.column>Kelas</flux:table.column>
                <flux:table.column>Jadwal</flux:table.column>
                <flux:table.column>Status</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($studentsData as $student)
                    <flux:table.row>
                        <flux:table.cell class="font-medium">
                            {{ $student['name'] }}
                        </flux:table.cell>

                        <flux:table.cell>
                            {{ $student['class_name'] }}
                        </flux:table.cell>

                        <flux:table.cell>
                            @if ($student['schedule_name'] === 'Tidak ada jadwal')
                                <span class="text-zinc-400 italic">Tidak ada jadwal</span>
                            @else
                                {{ $student['schedule_name'] }}
                            @endif
                        </flux:table.cell>

                        <flux:table.cell>
                            @if ($student['attendance_status'] === 'Belum ada sesi' || $student['attendance_status'] === 'Belum Dibuka')
                                <flux:badge color="zinc" icon="clock">{{ $student['attendance_status'] }}</flux:badge>
                            @elseif($student['attendance_status'] === 'Menunggu Absensi')
                                <flux:badge color="amber">Menunggu Absensi</flux:badge>
                            @elseif($student['attendance_status'] === 'Hadir')
                                <flux:badge color="green" icon="check-circle">Hadir</flux:badge>
                            @elseif(in_array($student['attendance_status'], ['Sakit', 'Izin']))
                                <flux:badge color="blue">{{ $student['attendance_status'] }}</flux:badge>
                            @elseif($student['attendance_status'] === 'Alfa')
                                <flux:badge color="red" icon="x-circle">Alfa</flux:badge>
                            @else
                                <flux:badge color="zinc">{{ $student['attendance_status'] }}</flux:badge>
                            @endif
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    @else
        {{-- Keterangan Ekstra (Hanya muncul jika SEMUA anak TIDAK ADA jadwal) --}}
        <div class="p-3 flex justify-center items-center px-4">
            <div
                class="flex lg:w-full min-h-37.5 lg:min-h-[200px] flex-col items-center text-center bg-zinc-50 py-4 px-2 rounded-lg border border-zinc-200 gap-3">
                <x-heroicon-o-clipboard-document-check
                    class="h-10 w-10 bg-zinc-100 rounded-full border border-zinc-200 p-2" />
                <p class="text-sm font-semibold text-zinc-900">
                    Belum Ada Absensi
                </p>

                <p class="text-sm text-zinc-600">
                    Data absensi akan tersedia setelah jadwal dimulai dan sesi absen telah dibuka.
                </p>
                <flux:button wire:navigate variant="primary" size="xs" class="md:px-5 md:py-2 md:text-sm">
                    Riwayat Absensi
                </flux:button>
            </div>
        </div>
    @endif
</flux:card>
