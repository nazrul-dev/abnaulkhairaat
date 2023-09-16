<x-guest-layout>


    <!-- Session Status -->
    

    <form method="POST" action="{{ route('password.email') }}">

        <x-card title="Forgot your password? ">

            @csrf
            <div class="mb-4 text-sm text-gray-600">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </div>
            <div class="space-y-5">
                <x-input id="email" :value="old('email')" label="{{ __('Email') }}" type="email" required autofocus
                    name="email" />

            </div>

            <x-slot name="footer">
                <div class="flex justify-end items-center">

                    <x-button type="submit" class="ml-3" primary label="{{ __('Email Password Reset Link') }}" />
                </div>
            </x-slot>


        </x-card>
    </form>
</x-guest-layout>
