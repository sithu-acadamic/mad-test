<!doctype html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
        <head>
            <meta charset="utf-8" />
            <title>SP-ADMIN</title>
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
            <meta content="" name="author" />
            <meta http-equiv="X-UA-Compatible" content="IE=edge" />
            <link rel="shortcut icon" href="">
            @include('admin.layouts.head-css')
        </head>

        @yield('body')

        @yield('content')

        @include('admin.layouts.vendor-scripts')
    </body>
</html>
