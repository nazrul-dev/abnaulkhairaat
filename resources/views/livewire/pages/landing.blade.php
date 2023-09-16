<div>
    <div class="bg-emerald-800 px-10 py-3 md:block hidden border-b border-emerald-900">
        <div class="flex justify-between items-center">
            <div class="text-xl font-semibold text-white">
                AbnaulKhairaat.com
            </div>
            <div class="flex gap-2">
                <x-button href="{{ route('login') }}" positive primary label="Login" />
                <x-button  href="{{ route('register') }}"  primary label="Register" />
            </div>
        </div>
    </div>
    <div class="mb-10">
        <div class="py-20 text-center  bg-emerald-800 text-white">
            <h1 class="mx-auto  md:max-w-4xl md:px-16 text-center font-bold leading-tight  tracking-tighter"><strong
                    class="md:text-7xl text-2xl">Bersatu Bersama </strong><br> <span class="md:text-5xl">Alumni Abnaul Kahiraat</span>
            </h1>

            <p class="mx-auto mt-3 md:max-w-xl max-w-sm md:text-xl text-sm font-normal text-gray-200">Bergabunglah bersama kami di Alumni
                Abnaul Kahiraat, di mana kenangan bertemu dengan masa depan. Jadilah bagian dari komunitas alumni yang
                erat dan berkontribusi pada kesuksesan kami bersama.</p>
            <div class="my-5 md:hidden block">
                <div class="flex justify-center gap-2">
                    <x-button href="{{ route('login') }}" positive primary label="Login" />
                    <x-button  href="{{ route('register') }}"  primary label="Register" />
                </div>

            </div>
        </div>
        {{-- <div class="w-1/2 -mt-20 mx-auto  rounded-2xl h-56 bg-emerald-700">

        </div> --}}
    </div>

</div>
