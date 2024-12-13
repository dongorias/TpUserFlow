<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


    <title>Laravel</title>

</head>
<body class="font-sans antialiased dark:bg-black dark:text-white/50">

 <div id="app">
        @yield('content')
    </div>

<script src="{{asset('bootstrap/js/bootstrap.js')}}"></script>
 <script src="https://cdn.jsdelivr.net/gh/livewire/sortable@v1.x.x/dist/livewire-sortable.js"></script>
</body>
</html>
