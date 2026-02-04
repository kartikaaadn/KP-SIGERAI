<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'SIGERAIMPP')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        *{
            box-sizing: border-box;
        }

        html, body{
            margin:0;
            padding:0;
            width:100%;
            min-height:100%;
            font-family: Arial, sans-serif;
        }

        /* 🔥 SATU BACKGROUND GEDUNG GLOBAL */
        body{
            background: url('{{ asset('assets/gedung.jpg') }}') center/cover no-repeat fixed;
        }

        /* overlay supaya teks kebaca */
        .app-overlay{
            min-height:100vh;
            width:100%;
            background: rgba(255,255,255,.45);
        }

        main{
            width:100%;
        }
    </style>
</head>
<body>

<div class="app-overlay">

    {{-- HEADER FULL --}}
    @yield('header')

    {{-- CONTENT --}}
    <main>
        @yield('content')
    </main>

    {{-- FOOTER FULL --}}
    @yield('footer')

</div>

</body>
</html>
