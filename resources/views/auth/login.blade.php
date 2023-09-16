<x-guest-layout>

   
    <form method="POST" action="{{ route('login') }}">
        <x-card title="Login Page ">

            @csrf
            <div class="space-y-5">
                <x-input :value="old('email')" label="{{ __('Email') }}" type="email" required autofocus name="email" />
                <x-inputs.password required autocomplete="current-password" type="password" name="password"
                    label="{{ __('Password') }}" />
            </div>
            <div class="block mt-4">
                <x-checkbox id="remember_me" name="remember" label="{{ __('Remember me') }}" />

            </div>
            <x-slot name="footer">
                <div class="flex justify-between items-center">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            href="{{ route('password.request') }}">
                           Lupa Password
                        </a>
                    @endif
                    <x-button type="submit" class="ml-3" primary label="{{ __('Log in') }}" />
                </div>
            </x-slot>


        </x-card>
        
        <div class="text-center my-5">
             <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            href="{{ route('register') }}">
                           Belum punya Akun ? 
                        </a>
        </div>
    </form>
</x-guest-layout>
