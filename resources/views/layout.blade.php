<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CSV Upload</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body class="bg-gray-100 p-6">

    <nav class="bg-white shadow mb-6">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
            <div>
                <a href="{{ url('/') }}" class="text-lg font-bold text-gray-700">Dashboard</a>
                <a href="{{ route('products.index') }}" class="ml-6 text-sm text-gray-600 hover:text-blue-600">Products</a>
            </div>
        </div>
    </nav>

    @yield('content')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
@if (session('uploadId'))
    <script>
        window.uploadId = {{ session('uploadId') }};
    </script>
@endif
    @vite(['resources/js/app.js'])
    @stack('scripts')
</body>

</html>
