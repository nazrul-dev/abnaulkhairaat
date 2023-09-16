<x-guest-layout>


    <form method="POST" action="{{ route('register') }}">
        <x-card title="Register Page ">

            @csrf
            <div class="space-y-2">
                <x-input :value="old('name')" label="{{ __('Name') }}" type="text" required autofocus name="name" />
                <x-input :value="old('email')" label="{{ __('Email') }}" type="email" required autofocus name="email" />
                <x-inputs.password required autocomplete="new-password" type="password" name="password"
                    label="{{ __('Password') }}" />
                    <x-inputs.password required autocomplete="new-password" type="password" name="password_confirmation"
                    label="{{ __('Confirm Password') }}" />
            </div>

            <x-slot name="footer">
                <div class="flex justify-between items-center">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                      Sudah Punya Akun ?
                    </a>
                    <x-button type="submit" class="ml-3" primary label="{{ __('Register') }}" />
                </div>
            </x-slot>


        </x-card>
    </form>
</x-guest-layout>



