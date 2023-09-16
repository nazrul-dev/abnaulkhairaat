<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @livewireStyles
    <wireui:scripts />

    <link rel="stylesheet" href="{{ asset('assets/app.css') }}">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="{{ asset('assets/app.js') }}" defer></script>
    
     <title>{{ $title ?? 'Abnaul Khairaat' }}</title>
</head>

<body class="bg-gray-200">

    <div class="md:max-w-sm md:p-0 p-2  mx-auto h-screen ">
        <div class="flex flex-col items-center  md:justify-center justify-end w-full   h-full">
            <div class="w-full">
                    {{ $slot }}
            </div>
        </div>

    </div>
    @livewireScriptConfig 
    @stack('scripts')

</body>

</html>
