<div>
    @if ($data['transaksi']['status'] !== 'UNPAID')
        <div>
            <div class="flex flex-col justify-center mt-20 items-center">
                <div class=" w-20 h-20 border rounded-full">
                    <img class="rounded-full  w-20 h-full object-cover" src="{{ asset('assets/success.gif') }}"
                        alt="">
                </div>
                <div class="text-center mt-5">
                    <div class="font-semibold">
                        Pembayaran kamu Sukses
                    </div>
                    <div class="text-sm">
                        terima kasih <strong>{{ auth()->user()->name }}</strong> atas donasinya


                        <div class="borde border-dashed p-2">
                            <blockquote>
                                “Sesungguhnya naungan seorang mukmin pada hari kiamat adalah sedekahnya” <br> <strong>(HR. Ahmad No.
                                    18043. Hadis sahih).</strong>
                            </blockquote>
                        </div>
                    </div>
                </div>
                <div class="mt-5">
                    <x-button positive href="/donasi" icon="arrow-narrow-left"> Kembali</x-button>

                </div>
            </div>
        </div>
    @else
        <div class="grid md:grid-cols-2 gap-4" wire:poll.keep-alive>
            <div>
                <x-card title="#{{ $data['transaksi']['reference'] }}">


                    <x-slot name="action">
                        @if ($data['transaksi']['status'] === 'UNPAID')
                            <x-badge negative label=" {{ $data['transaksi']['status'] }}" />
                        @else
                            <x-badge emerald label=" {{ $data['transaksi']['status'] }}" />
                        @endif

                    </x-slot>
                    <div class="flex flex-col items-center">
                        <div class="md: w-2/3 mx-auto text-center mb-5">
                            <p>sebelumnya kami mengucapkan terima kasih banyak atas donasi anda untuk event
                                <strong>{{ $data['transaksi']->user->name }}</strong>
                            </p>
                        </div>
                        <div>
                            Total yang harus didonasikan
                        </div>
                        <div class="font-bold text-3xl  mt-2 px-5 py-2 bg-slate-50 border-dashed border-2  rounded-lg">
                            @currency($data['tripay']['amount'])
                        </div>
                    </div>

                    <div class="mt-5 text-center font-semibold">
                        {{ $data['tripay']['payment_name'] }}
                    </div>

                    @if ($data['tripay']['pay_code'] === null && $data['tripay']['qr_url'])
                        <div class="rounded-lg  ">
                            <div class="justify-center items-center p-3  inline-flex w-full">
                                <img class="w-36 h-36 bg-slate-100 p-2" src="{{ data['transaksi']['qr_url'] }}"
                                    alt="{{ $data['transaksi']['pay_code'] }}">
                            </div>
                        </div>
                    @else
                        <div class="border mt-5 rounded-lg bg-slate-100 p-3">
                            <div class="flex justify-between items-center">
                                <div class="font-bold text-xl">
                                    {{ $data['transaksi']['pay_code'] }}
                                </div>
                                <div>
                                    <x-button primary icon="clipboard"
                                        x-clipboard.raw="{{ $data['transaksi']['pay_code'] }}" />
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="text-sm mt-2 text-negative font-semibold italic ">
                        lakukan transfer sebelum
                        {{ Carbon\Carbon::createFromTimestamp($data['transaksi']['expired_time'])->format('m-d-Y h:i') }}
                    </div>



                </x-card>
            </div>
            <div class="">
                <x-card title="Intruksi Pembayaran">
                    <div class="space-y-5">
                        @foreach ($data['tripay']['instructions'] as $k => $instruction)
                            <div class="border rounded-lg bg-slate-100 p-3">
                                <div class="flex justify-between items-center">
                                    {{ $instruction['title'] }}
                                    <div>
                                        <x-button x-bind:disabled="{{ $open === $k ? true : false }}"
                                            wire:click='changeOpen({{ $k }})'
                                            icon="{{ $open !== $k ? 'chevron-double-down' : 'chevron-double-up' }} " />
                                    </div>
                                </div>
                                <ul class=" {{ $open !== $k ? 'hidden' : '' }} list-decimal p-5 border-t mt-5 ">
                                    @foreach ($instruction['steps'] as $step)
                                        <li>{!! $step !!}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </x-card>
            </div>
        </div>
    @endif

</div>
