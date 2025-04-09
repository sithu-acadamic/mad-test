<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8" />
        <title>VXL - admin</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="" name="author" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <link rel="shortcut icon" href="">
        <link rel="shortcut icon" href="{{ URL::asset('user/images/favicon.png') }}" />
        <link href="{{ URL::asset('admin/css/common-theme.css') }}" rel="stylesheet" />
        @include('admin.layouts.head-css')
    </head>

    <body>
        @include('admin.layouts.sidebar')

        <div class="page-wrapper custom-background-gray">
            @include('admin.layouts.topbar')
            @include('admin.layouts.modal')
            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
                @include('admin.layouts.footer')
            </div>

        </div>
        @include('admin.layouts.vendor-scripts')
    </body>
</html>
