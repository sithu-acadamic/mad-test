<div class="left-sidenav">
    <!-- LOGO -->
    <div class="brand mt-2">
        <a href="index" class="logo">
                <span>
                    <img src="{{asset('admin/images/system/VXL_new_logo.png')}}" alt="logo-large" class="demo-logo-50">
                </span>
        </a>
    </div>
    <!--end logo-->
    <div class="menu-content h-100 mt-5" data-simplebar>
        <ul class="metismenu left-sidenav-menu">
{{--            <li class="mb-3"> <a href="{{ route('admin.product') }}"><i--}}
{{--                            class=""></i><span>Products</span></a>--}}
{{--            </li>--}}



            <li class="mb-3">
                <a href="javascript: void(0);"><i
                        class="fa fa-image fa-rotate-120"></i><span>IMAGES</span><span class="menu-arrow"><i
                            class="mdi mdi-chevron-right"></i></span></a>
                <ul class="nav-second-level" aria-expanded="false">

                    <li class="mb-3">
                        <a href="{{ route('admin.partnershipLogo') }}"><i
                                class="fa fa-home"></i><span>Partnership Logo</span></a>
                    </li>
                    <li class="mb-3"> <a href="{{ route('admin.settings') }}"><i
                                class="fa fa-globe"></i><span>Section Images</span></a>
                    </li>
                </ul>
            </li>

            <li class="mb-3">
                <a href="{{ route('admin.review') }}"><i
                        class="fa fa-comment"></i><span>GOOGLE REVIEW</span></a>
            </li>

            <li class="mb-3">
                <a href="{{ route('admin.our-services.index') }}"><i
                        class="fa fa-globe"></i><span>OUR SERVICE</span></a>
            </li>


            <li class="mb-3">
                <a href="{{ route('admin.teams.index') }}"><i
                        class="fa fa-user"></i><span>Teams</span></a>
            </li>

            <li class="mb-3">
                <a href="{{ route('admin.blogs.index') }}"><i
                        class="fa fa-pen"></i><span>Blog</span></a>
            </li>

            {{--<li class="mb-3">
                <a href="javascript: void(0);"><i
                            class="fa fa-ship"></i><span>Sea Export</span><span class="menu-arrow"><i
                                class="mdi mdi-chevron-right"></i></span></a>
                <ul class="nav-second-level" aria-expanded="false">

                    <li class="nav-item"><a class="nav-link" href=""><i
                                    class="ti-control-record"></i>LCL Rates</a></li>
                    <li class="nav-item"><a class="nav-link" href=""><i
                                    class="ti-control-record"></i>LCL Calculator</a></li>
                    <li class="nav-item"><a class="nav-link" href=""><i
                                    class="ti-control-record"></i>FCL Rates</a></li>
                    <li class="nav-item"><a class="nav-link" href=""><i
                                    class="ti-control-record"></i>FCL Calculator</a></li>
                </ul>
            </li>

            <li class="mb-3">
                <a href="javascript: void(0);"><i
                            class="fa fa-ship"></i><span>Sea Import</span><span class="menu-arrow"><i
                                class="mdi mdi-chevron-right"></i></span></a>
                <ul class="nav-second-level" aria-expanded="false">

                        <li class="nav-item"><a class="nav-link" href=""><i
                                        class="ti-control-record"></i>LCL Rates</a></li>
                    <li class="nav-item"><a class="nav-link" href=""><i
                                    class="ti-control-record"></i>LCL Calculator</a></li>
                        <li class="nav-item"><a class="nav-link" href=""><i
                                        class="ti-control-record"></i>FCL Rates</a></li>
                        <li class="nav-item"><a class="nav-link" href=""><i
                                        class="ti-control-record"></i>FCL Calculator</a></li>
                    </ul>
                </li>

            <li class="mb-3">
                <a href="javascript: void(0);"><i
                            class="fa fa-plane fa-flip-horizontal"
                            style="padding-left: 9px;"></i><span>Air Export</span><span class="menu-arrow"><i
                                class="mdi mdi-chevron-right"></i></span></a>
                <ul class="nav-second-level" aria-expanded="false">

                    <li class="nav-item"><a class="nav-link" href="#"><i
                                    class="ti-control-record"></i>Rates</a></li>
                    <li class="nav-item"><a class="nav-link" href="#"><i
                                    class="ti-control-record"></i>Calculator</a></li>
                </ul>
            </li>

            <li class="mb-3">
                <a href="javascript: void(0);"><i
                            class="fa fa-plane fa-rotate-120"></i><span>Air Import</span><span class="menu-arrow"><i
                                class="mdi mdi-chevron-right"></i></span></a>
                <ul class="nav-second-level" aria-expanded="false">

                    <li class="nav-item"><a class="nav-link" href="#"><i
                                    class="ti-control-record"></i>Rates</a></li>
                    <li class="nav-item"><a class="nav-link" href="#"><i
                                    class="ti-control-record"></i>Calculator</a></li>
                </ul>
            </li>

            <li class="mb-3">
                <a href="javascript: void(0);"><i
                            class="fa fa-users"></i><span>CRM</span><span class="menu-arrow"><i
                                class="mdi mdi-chevron-right"></i></span></a>
                <ul class="nav-second-level" aria-expanded="false">

                    <li class="nav-item"><a class="nav-link" href=""><i
                                        class="ti-control-record"></i>Company List</a></li>

                    <li class="nav-item"><a class="nav-link" href=""><i
                                    class="ti-control-record"></i>Tier List</a></li>
                </ul>
            </li>

            <li class="mb-3">
                <a href="javascript: void(0);"><i
                            class="fa fa-cash-register"></i><span>LOCAL CHARGES</span><span class="menu-arrow"><i
                                class="mdi mdi-chevron-right"></i></span></a>
                <ul class="nav-second-level" aria-expanded="false">

                    <li class="nav-item"><a class="nav-link" href=""><i
                                        class="ti-control-record"></i>SEA</a></li>
                </ul>
            </li>

            <li class="mb-3">
                <a href=""><i
                            class="fa fa-calendar"></i><span>Vessel Schedule</span></a>
            </li>
            <li class="mb-3">
                <a href="javascript: void(0);"><i
                            class="fas fa-cog"></i><span>Admin</span><span class="menu-arrow"><i
                                class="mdi mdi-chevron-right"></i></span></a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li class="nav-item"><a class="nav-link" href="#"><i
                                    class="fa fa-book"></i>Activity Log</a></li>
                </ul>
            </li>--}}
        </ul>
    </div>
</div>
