<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="HTML5 Template" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="description" content="Agrotek – Agriculture HTML Template" />
    <meta name="author" content="https://www.themetechmount.com/" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Elixcir Coco</title>

    <!-- favicon icon -->
    <link rel="shortcut icon" href="{{ URL::asset('user/images/favicon.png') }}" />
    @include('layouts.header-css')
</head>

<body>

<!--page start-->
<div class="page">

    <!-- preloader start -->
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div>
    <!-- preloader end -->

@include('layouts.navbar')

@yield('content')
    <!--footer start-->
@include('layouts.footer')
    <!--footer end-->

    <!--back-to-top start-->
    <a id="totop" href="#top">
        <i class="fa fa-angle-up"></i>
    </a>
    <!--back-to-top end-->

</div><!-- page end -->

<!-- Javascript -->

@include('layouts.scripts')

<!-- Javascript end-->

</body>
</html>
