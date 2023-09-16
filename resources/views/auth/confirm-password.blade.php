


<x-guest-layout>

   
    <form method="POST" action="{{ route('password.confirm') }}">
        <x-card title="Confirmation Password ">
            <div class="mb-4 text-sm text-gray-600">
                {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
            </div>
            @csrf
            <div class="space-y-5">

                <x-inputs.password required autocomplete="current-password" type="password" name="password"
                    label="{{ __('Password') }}" />
            </div>

            <x-slot name="footer">
                <div class="flex justify-end items-center">

                    <x-button type="submit" class="ml-3" primary label="{{ __('Confirm') }}" />
                </div>
            </x-slot>


        </x-card>
    </form>
</x-guest-layout>
