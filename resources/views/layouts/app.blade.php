<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('raja_gadai.ico') }}" type="image/x-icon">
    <title>Raja Gadai Note</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="font-sans antialiased">
    <div x-data="{ sidebarOpen: true }" class="h-screen flex overflow-hidden bg-gray-900 text-gray-300">
        @include('components.sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            <main class="flex-1 overflow-y-auto">
                {{ $slot }}
            </main>
        </div>

    </div>

    @livewireScripts
    @livewire('wire-elements-modal')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('actionCompleted', (event) => {
                // Tampilkan pesan sukses jika ada
                // if (event.message) {
                //     alert(event.message);
                // }

                // Reload halaman untuk melihat perubahan
                window.location.reload();
            });
        });
    </script>
</body>

</html>
