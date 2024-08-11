<x-filament::section class="my-20" aside>
    <x-slot name="heading">
        <span class="text-2xl font-bold">{{ $title }}</span>
    </x-slot>

    <x-slot name="description">
        Selamat datang di Website {{ config('app.name') }}, pastikan data anda sudah benar dan
        simpan dengan benar.
    </x-slot>

    <form wire:submit="create" class="space-y-6">
        {{ $this->form }}

        <x-filament::button type="submit">
            Submit
        </x-filament::button>
    </form>

    <x-filament-actions::modals />
    <livewire:notifications />

    <x-filament::modal id="success-modal" icon="heroicon-o-check-circle" icon-color="success">
        <x-slot name="heading">
            Data berhasil disimpan
        </x-slot>

        <x-slot name="description">
            Terima kasih, data yang anda masukan telah berhasil disimpan, Jika ada kesalahan, silahkan hubungi
            administrator.
        </x-slot>

        <p class="text-zinc-600 text-sm">
            Jika ada kesalahan, silahkan hubungi administrator.
        </p>
    </x-filament::modal>
</x-filament::section>
