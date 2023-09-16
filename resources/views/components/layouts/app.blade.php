<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @livewireStyles
    <wireui:scripts />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>{{ $title ?? 'Abnaul Khairaat' }}</title>
</head>

<body x-data="{ open: false }" class="soft-scrollbar">
    <x-notifications z-index="z-50" />
    <x-dialog  z-index="z-30" />
    <div class="h-screen bg-slate-100 dark:bg-gray-950 soft-scrollbar">
        <div :class="open ? 'w-0' : 'w-2/3 md:w-64'"
            class='md:z-5 z-20 md:block hidden transition duration-500 ease-in-out fixed
            bg-gray-900 text-white dark:bg-gray-900 overflow-y-auto h-full'>
            <div class=' sticky top-0'>
                <div class="flex justify-between items-center p-5 bg-[#1a174782]">
                    <div class="flex items-center gap-2 ">
                        <div class="w-7 h-7  bg-white rounded-lg p-[2px]">
                            <img src="{{ asset('assets/logo.png') }}" alt="">
                        </div>
                        <div class='text-xl font-bold tracking-tight transition-colors '>
                            SISMAL
                        </div>
                    </div>
                    <div class='md:hidden  block'>

                    </div>
                </div>

            </div>
            <div class=' font-semibold'>
                <div class="p-5 space-y-2">
                    <div class="p-2 hover:bg-slate-700 cursor-pointer rounded-lg ">
                        <a href="/" class="flex items-center gap-2">
                            <x-icon name="home" class="w-5 h-5" />
                            Dashboard
                        </a>
                    </div>

                    <div class="p-2 hover:bg-slate-700 cursor-pointer rounded-lg ">
                        <a href="/events" class="flex items-center gap-2">
                            <x-icon name="calendar" class="w-5 h-5" />
                            Events
                        </a>
                    </div>

                    <div class="p-2 hover:bg-slate-700 cursor-pointer rounded-lg ">
                        <a href="/diskusi" class="flex items-center gap-2">
                            <x-icon name="chat-alt-2" class="w-5 h-5" />
                            Diskusi
                        </a>
                    </div>

                    {{-- <div class="p-2 hover:bg-slate-700 cursor-pointer rounded-lg ">
                        <a href="/" class="flex items-center gap-2">
                            <x-icon name="office-building" class="w-5 h-5" />
                            Pembangunan
                        </a>
                    </div> --}}

                    <div class="p-2 hover:bg-slate-700 cursor-pointer rounded-lg ">
                        <a href="/donasi" class="flex items-center gap-2">
                            <x-icon name="gift" class="w-5 h-5" />
                            Donasi
                        </a>
                    </div>




                </div>

            </div>
        </div>
        <div :class="open ? 'w-full' : 'w-full md:w-[calc((100%-16rem))]'" class=' ml-auto h-full'>
            <header class=" flex flex-row sticky top-0 z-10 bg-slate-100  dark:bg-gray-950  text-gray-900">
                {{-- <button @click="open = ! open">Toggle Modal</button> --}}
                <div class="flex-1    p-2">
                    <div class="flex justify-end items-center md:pr-10">

                        <div class='flex items-center gap-2 '>

                            <div class="leading-5 flex flex-col items-end">
                                <div class="text-sm font-semibold">
                                    {{ auth()->user()->name }}
                                </div>
                                <p class="text-xs">{{ auth()->user()->email }}</p>
                            </div>
                            <div class="mt-[2px]">

                                <x-dropdown>
                                    <x-slot name="trigger">
                                        <x-avatar class="object-cover" md src="{{ asset('storage/' . auth()->user()->avatar) }}" />
                                    </x-slot>

                                    <div class="p-2">
                                        {{ auth()->user()->name }}
                                        <p class="text-xs">{{ auth()->user()->email }}</p>
                                    </div>
                                    <x-dropdown.item  href="/profile" separator label="Pengaturan Akun" />
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <x-dropdown.item separator label="Logout" :href="route('logout')"
                                            onclick="event.preventDefault();
                                            this.closest('form').submit();" />
                                    </form>

                                </x-dropdown>

                            </div>
                        </div>

                    </div>
                </div>
            </header>
            <main class='md:p-10  pb-[150px] p-2 bg-slate-100 dark:bg-gray-950'>
                {{ $slot }}
            </main>
        </div>
    </div>

    <div class="fixed md:hidden block bottom-0 left-0 z-10 w-full h-16 bg-white border-t border-gray-200 dark:bg-gray-700 dark:border-gray-600">
    <div class="grid h-full max-w-lg grid-cols-4 mx-auto font-medium">
        <a href="/" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 dark:hover:bg-gray-800 group">
            <x-icon solid
            class="w-5 h-5 mb-1 text-emerald-900 dark:text-gray-400 group-hover:text-emerald-900 dark:group-hover:text-blue-500"
            name="home" />
            <span class="text-sm text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500">Home</span>
        </a>
        <a href="/diskusi" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 dark:hover:bg-gray-800 group">
            <x-icon solid
            class="w-5 h-5 mb-1 text-emerald-900 dark:text-gray-400 group-hover:text-emerald-900 dark:group-hover:text-blue-500"
            name="chat-alt-2" />
            <span class="text-sm text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500">Diskusi</span>
        </a>
        <a href="/events" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 dark:hover:bg-gray-800 group">
            <x-icon solid
            class="w-5 h-5 mb-1 text-emerald-900  dark:text-gray-400 group-hover:text-emerald-900 dark:group-hover:text-blue-500"
            name="calendar" />
            <span class="text-sm text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500">Event</span>
        </a>
        <a href="/donasi" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 dark:hover:bg-gray-800 group">
            <x-icon solid
            class="w-5 h-5 mb-1 text-emerald-900 dark:text-gray-400 group-hover:text-emerald-900 dark:group-hover:text-blue-500"
            name="gift" />
            <span class="text-sm text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500">Donasi</span>
        </a>
    </div>
</div>
   @livewireScriptConfig 

    @stack('scripts')

</body>

</html>
