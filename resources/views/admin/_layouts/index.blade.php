<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Dashboard &mdash; Admin</title>

    @stack('cssScript')

</head>

<body>
<div id="app">
    <div class="main-wrapper">
        <div class="navbar-bg"></div>

        @include('admin._layouts.header')

        @include('admin._layouts.sidebar')

        <!-- Main Content -->
        <div class="main-content">
            @yield('content')
        </div>
        <!-- End Main Content -->

        @include('admin._layouts.footer')

    </div>
</div>

@stack('jsScript')

@stack('jsScriptAjax')

</body>
</html>
