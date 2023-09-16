<div>
    <div class="grid md:grid-cols-3 grid-cols-1 gap-2 md:gap-5">
        <div>
            <x-card title="Pilih Tipe Chat Angkatanmu">

                <div class="space-y-2">

                    @foreach ($angkatan as $item)
                        <div wire:click="selectedAngaktan({{ $item }})"
                            class=" {{ $item->tipe_angkatan === $ftipe_angkatan ? 'bg-emerald-800 text-white' : 'bg-slate-100' }} cursor-pointer rounded-lg p-2 border">
                            <div class="flex justify-between items-center">
                                <div class="flex-1">
                                    <strong class="uppercase">{{ $item->tipe_angkatan }}</strong> Angkatan
                                    {{ $item->angkatan }}
                                </div>

                            </div>
                        </div>
                    @endforeach

                    <div wire:click="selectedAngaktan('public')"
                        class=" {{ $public ? 'bg-emerald-800 text-white' : 'bg-slate-100' }} cursor-pointer rounded-lg p-2 border">
                        <div class="flex justify-between items-center">
                            <div class="flex-1">
                                <strong class="uppercase">Public Chat </strong>
                            </div>

                        </div>
                    </div>
                </div>
            </x-card>
        </div>
        <div class="md:col-span-2">
            <x-card
                title="Ruang Diskusi Angkatan {{ $public ? 'Public' : Str::upper($ftipe_angkatan) . '-' . $fangkatan }} ">
                <div id="chats"
                    class="h-96 overflow-y-auto flex  flex-col-reverse  overflow-x-hidden p-5 soft-scrollbar gap-3 "
                    wire:poll.keep-alive>
                    @foreach ($chats as $chat)
                        @if ($chat->user->id === auth()->id())
                            <div class=" flex flex-row-reverse justify-end items-start gap-2 md:text-normal text-sm ">
                                <div>

                                    <x-avatar md src="{{ asset('storage/' . auth()->user()->avatar) }}" />
                                </div>
                                <div class="flex-1 ">
                                    <div class="bg-emerald-800 text-white p-3 w-2/3 ml-auto rounded-lg">
                                        <div
                                            class="font-semibold -pt-2 flex flex-col  md:flex-row-reverse justify-between md:items-center">
                                            <div>
                                                {{ $chat->user->name }}
                                            </div>
                                            <div class="italic  md:text-sm text-xs ">
                                                {{ $chat->created_at }}
                                            </div>

                                        </div>
                                        <p class="break-words text-sm">
                                            {{ $chat->pesan }}

                                        </p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="flex items-start gap-2 text-sm md:text-normal">
                                <div>
                                    <x-avatar md src="{{ asset('storage/' . $chat->user->avatar) }}" />
                                </div>
                                <div class="flex-1 ">
                                    <div class="bg-slate-100 p-3 w-2/3 rounded-lg">
                                        <div>
                                            <div class="font-semibold -pt-2 flex justify-between items-center">
                                                {{ $chat->user->name }}
                                                <div class="italic  md:text-sm text-xs ">
                                                    {{ $chat->created_at }}
                                                </div>
                                            </div>
                                        </div>
                                        <p class="break-words text-sm">
                                            {{ $chat->pesan }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach


                </div>
                @if ($ftipe_angkatan || $public)
                    <x-slot name="footer">
                        <div class="flex justify-between items-center gap-2">
                            <div class="flex-1">
                                <x-input wire:model.defer="pesan" placeholder="Tuliskan Pesanmu" />
                            </div>
                            <div>
                                <x-button wire:click="send" primary>
                                    <x-slot name="label">
                                        <div class="flex group">
                                            <x-icon name="paper-airplane"
                                                class="w-5 h-5  transition duration-500 ease-in-out group-hover:rotate-90" />
                                            <div class="md:block hidden ml-2">
                                                Kirim Pesan
                                            </div>

                                        </div>
                                    </x-slot>

                                </x-button>
                            </div>
                        </div>
                    </x-slot>
                @endif

            </x-card>
        </div>
    </div>
</div>
@push('scripts')
    <script type="text/javascript">
        var container = document.getElementById('chats');
        var dispatchEnabled = true; // Variable untuk mengontrol apakah dispatch masih diperbolehkan

        container.addEventListener('scroll', function() {
            if (dispatchEnabled) {
                if (container.scrollTop + container.clientHeight >= container.scrollHeight) {
                    // Scroll sudah mencapai akhir
                    Livewire.dispatch('loadmore');
                    dispatchEnabled = false; // Nonaktifkan dispatch setelah mencapai akhir
                }
            }
        });
    </script>
@endpush
