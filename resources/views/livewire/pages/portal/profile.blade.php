<div>
    <div class="md:w-1/2 w-full mx-auto">
        <x-card title="Pengaturan Akun">
            <div class="flex gap-2 items-center justify-center">
                <x-avatar xl src="{{ asset('storage/' . auth()->user()->avatar) }}" />

            </div>
            <div class="grid grid-cols-1 gap-2">
                <x-input wire:model="pic"  hint="Kosongkan Apabila anda tidak ingin menganti Foto Profil" type="file" label="Foto Profil"  />
                <x-input wire:model="fields.name" label="Nama" placeholder="Input Nama" />
                <x-input wire:model="fields.phone" label="Nomor Telepon" placeholder="Input Nomor Telepon" />
                <x-input wire:model="fields.phone_wa" label="Nomor Whatsapp" placeholder="Input Nomor Whatsapp" />

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

                <div class="grid grid-cols-1 gap-5 ">
                    <x-select hide-empty-message label="Pilih Kecamatan" wire:model="fields.district"
                        placeholder="Pilih Kecamatan" :async-data="route('get-district')" option-label="name" option-value="id">
                    </x-select>
                </div>
                <div>
                    <x-textarea wire:model.defer="fields.current_address" label="Alamat ( Sesuai KTP )"
                        placeholder="Tuliskan Alamat kamu" />
                </div>
                <x-inputs.password hint="Kosongkan Apabila anda tidak ingin menganti password" required
                    autocomplete="new-password" type="password" wire:model='password' name="password"
                    label="{{ __('Password') }}" />
                <x-inputs.password hint="Kosongkan Apabila anda tidak ingin menganti password" required
                    autocomplete="new-password" type="password" wire:model='password_confirmation'
                    name="password_confirmation" label="{{ __('Confirm Password') }}" />

            </div>
            <x-slot name="footer">
                <div class="flex justify-end gap-x-4">

                    <x-button type="button" wire:click="save" primary spinner label="Simpan" />

                </div>
            </x-slot>
        </x-card>
    </div>
</div>
