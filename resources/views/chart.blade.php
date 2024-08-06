<html lang="en">
    <head>
        <title>Chart</title>
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
        {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
        @livewireStyles
        @livewireScripts
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body>
        <div class="p-4">
            @livewire('chart-orders')
        </div>
    </body>
</html>