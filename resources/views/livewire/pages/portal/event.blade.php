<div>
    <div class="flex  z-20  md:justify-between md:flex-row flex-col md:items-center gap-2 mb-5">
        <div>
            <strong class="md:text-lg text-sm">Berbagai Event Untuk Kamu</strong>
            <p class="text-sm text-gray-500 ">Kami dengan tulus mengundang Anda untuk mengikuti Event kami.</p>
        </div>
        <div class="flex gap-2 sticky ">
            @if (auth()->user()->isadmin)
            <x-button wire:click='form'  positive icon="plus" label=" Event" />
            @endif


        </div>
    </div>
    <div class="grid md:grid-cols-3 gap-5">
        @foreach ($events as $event)
            <x-card>
                <x-slot name="title">
                    <span class="text-sm"> Status Event :</span> <x-badge primary label="Berjalan" />
                </x-slot>
                @if (auth()->user()->isadmin)
                <x-slot name="action">
                    <x-dropdown>
                        <x-dropdown.item spinner wire:click='form({{ $event }})' label="Edit Event" />
                        <x-dropdown.item spinner wire:click='handlerDelete({{ $event->id }})' label="Hapus Event" />

                    </x-dropdown>
                </x-slot>
                @endif
                <div class="relative group h-56">
                    <div
                        class="absolute group-hover:block hidden bg-emerald-100 bg-opacity-75 rounded-xl w-full h-full">
                        <div class="flex justify-center items-center flex-col h-full">
                            <x-button wire:click="handlerShowPoster('{{ asset('storage/' . $event->poster) }}')" primary
                                sm icon="eye" />
                        </div>
                    </div>
                    <img class="object-cover h-full w-full rounded-xl border"
                        src="{{ asset('storage/' . $event->poster) }}" alt="">
                </div>
                <div class="p-2">

                    <div class="font-semibold leading-5">
                        {{ $event->nama }}
                    </div>
                    <p class="text-sm text-gray-500">
                    <div class="grid my-5 gap-2 pt-3 border-t-2 border-dashed">
                        <div class="flex flex-col">
                            <div class="flex gap-2">
                                <span class="text-xs ml-6 font-semibold">Lokasi Event :</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <x-icon name="location-marker" class="w-4 h-4 " />
                                <p class="italic leading-5 text-sm"> {{ $event->lokasi }}</p>
                            </div>

                        </div>
                        <div class="flex flex-col">
                            <div class="flex gap-2">
                                <span class="text-xs ml-6 font-semibold">Tanggal Event :</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <x-icon name="calendar" class="w-4 h-4" />
                                <p class="text-sm">{{ $event->tanggal_mulai }} - {{ $event->tanggal_berakhir }}</p>
                            </div>

                        </div>

                        <div class="flex flex-col">
                            <div class="flex gap-2">
                                <span class="text-xs ml-6 font-semibold">Penanggung Jawab :</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <x-icon name="user" class="w-4 h-4" />
                                <p class="text-sm"> {{ $event->penanggung_jawab }}</p>
                            </div>

                        </div>

                    </div>
                </div>
                <x-slot name="footer">
                    <div class="flex md:flex-row flex-col gap-2 justify-between items-center">
                        <x-button icon="users" positive label="Total Donator {{ $event->getTotalDonation() }}" />
                        <x-button icon="gift"  wire:click='donation({{ $event }})' label="Donasi" primary />
                    </div>
                </x-slot>
            </x-card>
        @endforeach


    </div>
    <x-modal.card title="{{ $ids ? 'Edit' : 'Tambah' }} Event" blur wire:model.defer="modalForm">
        <div class="grid md:grid-cols-2 gap-2">

            <div class="md:col-span-2">
                <x-input wire:model="nama" label="Nama Event" placeholder="Input Nama Event" />
            </div>
            <div class="md:col-span-2">
                <x-input wire:model="penanggung_jawab" label="Penanggung Jawab Acara"
                    placeholder="Input Nama Penanggung Jawab Acara" />

            </div>
            <x-datetime-picker label="Tanggal Mulai Event" placeholder="Input Tanggal"
                wire:model.live="tanggal_mulai" />
            <x-datetime-picker label="Tanggal Selesai Event" placeholder="Input Tanggal"
                wire:model.live="tanggal_berakhir" />
            <div class="md:col-span-2">
                <x-textarea wire:model="lokasi" label="Lokasi Acara" placeholder="Tuliskan Lokasi / Alamat Acara" />
            </div>


            <div class="md:col-span-2">
                <x-input hint="{{ $ids ? 'Abaikan Jika Anda tidak ingin mengubah poster Event' : '' }}"
                    wire:model="poster" label="Poster Acara" type="file" />
            </div>

        </div>
        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">


                <div class="flex">
                    <x-button flat spinner label="Cancel" x-on:click="close" />
                    <x-button primary spinner label="Save" wire:click="save" />
                </div>
            </div>
        </x-slot>
    </x-modal.card>
    <x-modal.card title="Donasi Event" blur wire:model.defer="modalDonationShow">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mb-5">
            @if ($eventSelected)
            <div class="md:col-span-2">
                <x-input disabled value="{{  $eventSelected['nama'] }}" label="Nama Event" placeholder="{{  $eventSelected['nama'] }}" />
            </div>
            @endif
            <x-input disabled label="Nama Pendonasi" value="{{ auth()->user()->name }}" />
            <x-inputs.currency label="Jumlah Donasi" placeholder="Jumlah Donasi" wire:model="donationAmount" />
        </div>

        <div class="my-3 font-semibold">
            Pilih Metode Pembayaran
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">

            @foreach ($channelPembayaran as $k => $channel)
                <div wire:click="selectedChannel({{ $k }})"
                    class="{{ $channelSelected && $channelSelected['code'] === $channel['code'] ? 'bg-slate-300 text-gray-900' : ' bg-slate-100' }} flex gap-5 items-center p-2 border rounded-lg cursor-pointer ">
                    <img class="w-20 h-auto" src="{{ $channel['icon_url'] }}" alt="  {{ $channel['name'] }}">
                    <div class="font-semibold">
                        {{ $channel['name'] }}
                    </div>
                </div>
            @endforeach

        </div>
        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">


                <div class="flex">
                    <x-button flat spinner label="Cancel" x-on:click="close" />
                    <x-button primary spinner label="Checkout Pembayaran" wire:click="checkout" />
                </div>
            </div>
        </x-slot>
    </x-modal.card>
    <x-modal blur wire:model.defer="modalPosterShow" wire:click='handlerModalShowPoster()'>
        <div class="h-screen w-[100vh]">
            <div class="flex flex-col items-center justify-center  h-full">
                <img class="w-auto h-auto" src="{{ $posterShow }}" alt="">
            </div>
        </div>

    </x-modal>
</div>

@push('scripts')
    <script type="text/javascript">
        window.onscroll = function(ev) {
            if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
                Livewire.dispatch('loadmore');
            }
        };
    </script>
@endpush
