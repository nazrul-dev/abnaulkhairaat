<div>
    <x-modal wire:model.defer="modal" blur hide-close>
        <x-card title="Lengkapi {{ $step === 1 ? 'Biodatamu' : 'Angkatan' }}">
            @if ($step === 1)
                <div class="space-y-2">
                    <div class="grid grid-cols-1 gap-2 ">
                        <x-select hide-empty-message label="Pilih Kecamatan" wire:model="fields.district"
                            placeholder="Pilih Kecamatan" :async-data="route('get-district')" option-label="name" option-value="id">
                        </x-select>
                    </div>
                    <div class="grid md:grid-cols-2 gap-2 ">
                        <x-input wire:model="fields.phone" label="Nomor Telepon" placeholder="Input Nomor Telepon" />
                        <x-input wire:model="fields.phone_wa" label="Nomor Whatsapp" placeholder="Input Nomor Whatsapp" />
                    </div>
                    <div class="grid md:grid-cols-2 gap-2 ">
                        <x-select label="Status Hubungan" placeholder="Pilih Status Hubungan" :options="['Lajang', 'Duda', 'Janda', 'Menikah']"
                            wire:model.lazy="fields.status_hubungan" />
                        <x-select label="Pekerjaan" placeholder="Pilih Pekerjaan" :options="[
                            'Karyawan Swasta',
                            'Wirausaha',
                            'POLRI',
                            'TNI',
                            'PNS',
                            'BUMN',
                            'BUMD',
                            'MAGANG',
                            'Guru',
                            'Tidak Punya Pekerjaan',
                        ]"
                            wire:model.defer="fields.pekerjaan" />
                    </div>


                    <div>
                        <x-textarea wire:model.defer="fields.current_address" label="Alamat ( tidak wajib )"
                            placeholder="Tuliskan Alamat kamu" />
                    </div>
                </div>
            @elseif ($step === 2)
                <div class="space-y-2">
                    <div class="flex flex-col gap-2">

                        <x-checkbox id="right-label1" label="MI ( Madrasah Ibtidayah)" wire:model.live="type.mi" />
                        <x-checkbox id="right-label2" label="MTS ( Madrasah Tsanawiyah)" wire:model.live="type.mts" />
                        <x-checkbox id="right-label3" label="MA  ( Madrasah Aliyah )" wire:model.live="type.ma" />
                    </div>


                    @foreach ($type as $k => $item)
                        @if ($item)
                            <div class="p-5 border-y">
                                <div class="grid md:grid-cols-3 gap-4">
                                    <x-input value="{{ Str::upper($k) }} " label="Tipe Angkatan" readonly="true" />
                                    <x-input type="number" wire:model="fieldsType.{{ $k }}.angkatan"
                                        label="Angkatan Masuk" placeholder="2020" />

                                    <x-input type="number" wire:model="fieldsType.{{ $k }}.tahun_kelulusan"
                                        label="Tahun Kelulusan" placeholder="2023" />

                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
            <x-slot name="footer">

                <div class="flex justify-end gap-x-4">
                    @if ($step === 2 && $countType >= 1)
                        <x-button type="button" wire:click="save" primary spinner label="Simpan" />
                    @elseif($step === 1)
                        <x-button type="button" wire:click="nextStep" primary spinner label="Lanjutkan" />
                    @endif
                </div>
            </x-slot>
        </x-card>
    </x-modal>
</div>
