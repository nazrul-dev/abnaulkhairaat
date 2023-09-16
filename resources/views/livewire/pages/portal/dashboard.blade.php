<div>
    <div class="space-y-4">
        <div class="grid md:grid-cols-4 gap-5">

                <div class="border rounded-lg bg-emerald-900 p-5">
                    <div class="flex item-center gap-5">
                        <div class="w-12 bg-emerald-200 rounded-lg flex flex-col items-center justify-center">
                            <x-icon name="academic-cap" solid class="w-8 h-8 text-emerald-900" />
                        </div>
                        <div class="leading-5">
                            <div class="text-gray-200 text-sm font-semibold">
                               Total Alumni Keseluruhan
                            </div>
                            <div class="leading-2 text-lg text-white font-bold">
                                {{ $userCount  }} <small class="text-normal">Orang</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="border rounded-lg bg-emerald-900 p-5">
                    <div class="flex item-center gap-5">
                        <div class="w-12 bg-emerald-200 rounded-lg flex flex-col items-center justify-center">
                            <x-icon name="gift" solid class="w-8 h-8 text-emerald-900" />
                        </div>
                        <div class="leading-5">
                            <div class="text-gray-200 text-sm font-semibold">
                               Total Donasi Keseluruhan
                            </div>
                            <div class="leading-2 text-lg text-white font-bold">
                                @currency($totalDonation)
                            </div>
                        </div>
                    </div>
                </div>
                <div class="border rounded-lg bg-emerald-900 p-5">
                    <div class="flex item-center gap-5">
                        <div class="w-12 bg-emerald-200 rounded-lg flex flex-col items-center justify-center">
                            <x-icon name="hashtag" solid class="w-8 h-8 text-emerald-900" />
                        </div>
                        <div class="leading-5">
                            <div class="text-gray-200 text-sm font-semibold">
                               Jumlah Angkatan
                            </div>
                            <div class="leading-2 text-lg text-white font-bold">


                                 {{ $angkatan['jumlahAngkatan'] }} / {{ $angkatan['angkatanTerendah'] }} - {{ $angkatan['angkatanTetinggi'] }}
                            </div>
                        </div>
                    </div>

                </div>
                <div class="border rounded-lg bg-emerald-900 p-5">
                    <div class="flex item-center gap-5">
                        <div class="w-12 bg-emerald-200 rounded-lg flex flex-col items-center justify-center">
                            <x-icon name="calendar" solid class="w-8 h-8 text-emerald-900" />
                        </div>
                        <div class="leading-5">
                            <div class="text-gray-200 text-sm font-semibold">
                               Total Event
                            </div>
                            <div class="leading-2 text-lg text-white font-bold">
                                 {{ $event }} <small class="text-normal">Event</small>
                            </div>
                        </div>
                    </div>

                </div>
        </div>
        <x-card title="  Statistik Data Pekerjaan">
            <div class="grid md:grid-cols-4 gap-5">
                @foreach ($pekerjaanCounts as $pekerjaan)
                    <div class="border rounded-lg bg-slate-100 p-2">
                        <div class="flex item-center gap-5">
                            <div class="w-12 bg-emerald-200 rounded-lg flex flex-col items-center justify-center">
                                <x-icon name="users" solid class="w-8 h-8 text-emerald-900" />
                            </div>
                            <div class="leading-5">
                                <div class="text-gray-500 text-sm font-semibold">
                                    {{ $pekerjaan->pekerjaan }}
                                </div>
                                <div class="leading-2 text-lg font-bold">
                                    {{ $pekerjaan->jumlah_pengguna }} <small class="text-normal">Orang</small>
                                </div>
                            </div>
                        </div>

                    </div>
                @endforeach

            </div>
        </x-card>


        <x-card title="  Statistik Data Alumni">
            <div class="flex gap-2">
                @foreach ($groupedDataAngkatan as $k => $angkatan)
                    <button wire:click="selectedTipeAngkatan('{{ $k }}')"
                        class="{{ $tipeAngkatanSelected === $k ? 'bg-emerald-900 text-white' : 'bg-slate-200' }}  uppercase font-bold border px-5 py-2 rounded-lg">
                        {{ $k }}
                    </button>
                @endforeach


            </div>
            <div>
                @if ($tipeAngkatanSelected)
                    <div class="grid md:grid-cols-6  gap-5 mt-5">
                        @foreach ($groupedDataAngkatan[$tipeAngkatanSelected] as $item)
                            <div class="border rounded-lg bg-slate-100  p-2">
                                <div class="flex item-center gap-5">
                                    <div
                                        class="w-12 bg-emerald-200 rounded-lg flex flex-col items-center justify-center">
                                        <x-icon name="users" solid class="w-8 h-8 text-emerald-900" />
                                    </div>
                                    <div class="leading-5">
                                        <div class="text-gray-500 text-sm font-semibold">
                                            {{ $item['angkatan'] }}
                                        </div>
                                        <div class="leading-2 text-lg font-bold">
                                            {{ $item['jumlah_pengguna'] }} <small class="text-normal">Orang</small>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </x-card>
    </div>
</div>
