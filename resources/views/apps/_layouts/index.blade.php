<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Apotek Narisa</title>
    <link rel="shortcut icon" href="{{ url('logo.png') }}" type="image/x-icon" />

    @stack('cssScript')

</head>

<body class="layout-3">
    <div id="app">
        <div class="main-wrapper container">
            <div class="navbar-bg"></div>

            @include('apps._layouts.header')

            <!-- Main Content -->
            <div class="main-content">
                @yield('content')
            </div>
            <!-- End Main Content -->

            @include('apps._layouts.footer')

        </div>
    </div>

    @stack('jsScript')

    @stack('jsScriptAjax')
</body>

</html>