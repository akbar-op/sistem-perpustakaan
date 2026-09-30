<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Perpustakaan</title>

    @fonts

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="min-h-screen bg-[#f7f9fc] font-sans text-[#253858]">

    <div class="flex min-h-screen flex-col lg:flex-row">
        @include('layout.sidebar')

        @yield('content')
    </div>
</body>

</html>