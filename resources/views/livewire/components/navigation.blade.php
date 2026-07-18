<flux:sidebar sticky stashable class="bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700">
    {{-- Tombol close (muncul di mobile saat sidebar dibuka) --}}
    <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

    {{-- Brand/Logo --}}
    <flux:brand href="/dashboard" name="Sistem Absensi" class="px-2" />

    {{-- Menu Utama --}}
    <flux:navlist variant="outline">
        <flux:navlist.item icon="home" href="/dashboard" wire:navigate>
            Home
        </flux:navlist.item>
        
        <flux:navlist.item icon="qr-code" href="/absen" wire:navigate>
            Absen
        </flux:navlist.item>
        
        <flux:navlist.item icon="document-text" href="/izin" wire:navigate>
            Izin
        </flux:navlist.item>
    </flux:navlist>

    {{-- Spacer untuk mendorong menu profil ke bawah --}}
    <flux:spacer />

    {{-- Menu Bottom (opsional dipisah, biasanya untuk Profil/Settings) --}}
    <flux:navlist variant="outline">
        <flux:navlist.item icon="user" href="/profil" wire:navigate>
            Profil
        </flux:navlist.item>
    </flux:navlist>
</flux:sidebar>