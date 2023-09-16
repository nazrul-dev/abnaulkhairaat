


<x-guest-layout>

    
    <form method="POST" action="{{ route('password.store') }}}">
        <x-card title="Reset Your Password ">

            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">
            <div class="space-y-2">

                <x-input :value="old('email')" label="{{ __('Email') }}" type="email" required autofocus name="email" />
                <x-inputs.password required autocomplete="new-password" type="password" name="password"
                    label="{{ __('Password') }}" />
                    <x-inputs.password required autocomplete="new-password" type="password" name="password_confirmation"
                    label="{{ __('Confirm Password') }}" />
            </div>

            <x-slot name="footer">
                <div class="flex justify-end items-center">

                    <x-button type="submit" class="ml-3" primary label=" {{ __('Reset Password') }}" />
                </div>
            </x-slot>


        </x-card>
    </form>
</x-guest-layout>



