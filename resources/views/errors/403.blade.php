<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>403 - Forbidden</title>
    @vite('resources/css/app.css')
</head>

<body class="antialiased">
    <div class="min-h-screen bg-gray-900 flex flex-col items-center justify-center p-6 overflow-hidden relative">
        <!-- Giant 403 Text -->
        <div class="flex items-center justify-center">
            <div style="font-size: 10rem;" class="font-bold text-white opacity-70 leading-none">
                403
            </div>
        </div>

        <!-- Content Container -->
        <div class="max-w-md w-full text-center space-y-6 relative z-10 bg-900 bg-opacity-90 p-8 rounded-lg">
            <h1 class="text-4xl font-light text-white">Access Denied</h1>
            <div class="text-gray-200 space-y-3 text-lg">
                <p>You do not have permission to access this resource.</p>
                <p>Please check your access rights or contact support.</p>
            </div>

            <div class="pt-8 flex justify-center gap-4">
                <a href="{{ url()->previous() }}"
                    class="px-6 py-3 border border-gray-300 text-white font-medium rounded-lg hover:bg-gray-500 transition-colors flex items-center">
                    ← Back
                </a>
                <a href="{{ url('/dashboard') }}"
                    class="px-6 py-3 bg-gray-800 text-white font-medium rounded-lg hover:bg-gray-500 transition-colors flex items-center">
                    Dashboard
                </a>
            </div>
        </div>
    </div>
</body>

</html>
