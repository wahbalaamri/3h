<!DOCTYPE html>
<html lang="en-US">

<head>
    <title>HR FACTORY</title>
    <meta name="author" content="HR Factory">
    <meta name="robots" content="index follow">
    <meta name="googlebot" content="index follow">
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="keywords" content="HR Factory">
    <meta name="description" content="HR Factory">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/png" href="ContentImages/favicon.png" />
    <!-- google fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kalam:wght@700&display=swap" rel="stylesheet">



    <!-- animate -->
    <link href="{{ asset('assets/css/animate.css') }}">

    <!-- owl Carousel assets -->
    <link href="{{ asset('assets/css/owl.carousel.css') }}">


    <link href="{{ asset('assets/css/owl.theme.css') }}">


    <!-- bootstrap -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}">

    <!-- hover anmation -->
    <link href="{{ asset('assets/css/hover-min.css') }}">
    <!-- <link rel="stylesheet" href="~/assets/css/hover-min.css"> -->
    <!-- flag icon -->
    <link href="{{ asset('assets/css/flag-icon.min.css') }}">
    <!-- <link rel="stylesheet" href="~/assets/css/flag-icon.min.css"> -->

    <!-- main style -->
    <link href="{{ asset('assets/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <!-- colors -->
    <link href="{{ asset('assets/css/colors/main.css') }}">
    <!-- <link rel="stylesheet" href="~/assets/css/colors/main.css"> -->
    <!-- elegant icon -->
    <link href="{{ asset('assets/css/elegant_icon.css') }}">
    <!-- <link rel="stylesheet" href="~/assets/css/elegant_icon.css"> -->
    <!-- jquery  UI style  -->
    <link href="{{ asset('assets/Content/themes/base/jquery-ui.css') }}">
    <!-- <link href="~Content/themes/base/jquery-ui.css" rel="stylesheet" /> -->
    <link href="{{ asset('assets/Content/themes/base/jquery-ui.min.css') }}">
    <!-- <link href="~assets/Content/themes/base/jquery-ui.min.css" rel="stylesheet" /> -->
    <!-- jquery library  -->
    <script type="text/javascript" src="{{ asset('assets/js/jquery-3.2.1.min.js') }}"></script>
    <!-- jquery UI library  -->
    <script src="{{ asset('assets/Scripts/jquery-ui-1.13.0.js') }}"></script>
    <script src="{{ asset('assets/Scripts/jquery-ui-1.13.0.min.js') }}"></script>
    <!-- fontawesome  -->
    <script src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
    <!-- google maps api  -->


    <script src="{{ asset('assets/Scripts/jquery-gauge.min.js') }}"></script>
    <script src="{{ asset('assets/Scripts/toastr.min.js') }}"></script>
    <link href="{{ asset('assets/Content/jquery-gauge.css') }}" as="style" onload="this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="{{ asset('assets/Content/jquery-gauge.css') }}">
    </noscript>
    <!-- <link href="~/Content/jquery-gauge.css" rel="stylesheet" /> -->
    <link href="{{ asset('assets/Content/toastr.css') }}" as="style" onload="this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="{{ asset('assets/Content/toastr.css') }}">
    </noscript>
    <!-- <link href="~/Content/toastr.css" rel="stylesheet" /> -->
    <!-- REVOLUTION STYLE SHEETS -->
    <link href="/assets/revslider/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" as="style">
    <!-- <link rel="stylesheet" type="text/css" href="~/assets/revslider/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css"> -->

    <link rel="stylesheet" type="text/css" href="/assets/revslider/fonts/font-awesome/css/all.css">
    <link href="/assets/revslider/css/settings.css" as="style">
    <!-- <link rel="stylesheet" type="text/css" href="~/assets/revslider/css/settings.css"> -->


    <link href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;700;900&display=swap"
        rel="stylesheet">

    <!-- REVOLUTION LAYERS STYLES -->
    <!-- REVOLUTION JS FILES -->
    <script type="text/javascript" src="/assets/revslider/js/jquery.themepunch.tools.min.js"></script>
    <script type="text/javascript" src="/assets/revslider/js/jquery.themepunch.revolution.min.js"></script>

    <!-- SLIDER REVOLUTION 5.0 EXTENSIONS  (Load Extensions only on Local File Systems !  The following part can be removed on Server for On Demand Loading) -->
    <script type="text/javascript" src="/assets/revslider/js/extensions/revolution.extension.actions.min.js"></script>
    <script type="text/javascript" src="/assets/revslider/js/extensions/revolution.extension.carousel.min.js"></script>
    <script type="text/javascript" src="/assets/revslider/js/extensions/revolution.extension.kenburn.min.js"></script>
    <script type="text/javascript" src="/assets/revslider/js/extensions/revolution.extension.layeranimation.min.js">
    </script>
    <script type="text/javascript" src="/assets/revslider/js/extensions/revolution.extension.migration.min.js"></script>
    <script type="text/javascript" src="/assets/revslider/js/extensions/revolution.extension.navigation.min.js">
    </script>
    <script type="text/javascript" src="/assets/revslider/js/extensions/revolution.extension.parallax.min.js"></script>
    <script type="text/javascript" src="/assets/revslider/js/extensions/revolution.extension.slideanims.min.js">
    </script>
    <script type="text/javascript" src="/assets/revslider/js/extensions/revolution.extension.video.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.15.0/full/ckeditor.js"></script>
    <script src="{{ asset('assets/Scripts/jquery.blockUI.js') }}"></script>
    @vite(['resources/js/app.js'])
    @stack('styles')
</head>

<body class="background-white">


    <!-- header -->
    <header class="gradient-white box-shadow">
        <div class="background-grey-2 padding-tb-5px position-relative">
            <div class="container" style="max-width: 98%">
                <div class="row">
                    <div class="col-6 text-white float-start">{{-- العربية --}}</div>
                    <div class="col-6 text-white text-end">
                        <div class="row">
                            <div class="col-6"></div>
                            {{-- login or logout --}}
                            @if (Auth::check())
                            <div class="col-3">
                                <a href="{{ route('users.changePassword',auth()->user()->id) }}" class="text-white text-decoration-none" >
                                <i class="fas fa-key"></i>
                                {{ __('Change Password') }}
                            </a>
                            </div>
                            <div class="col-3 text-start">
                                <a href="{{ route('logout') }}" class="text-white text-decoration-none" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt"></i>
                                    {{ __('Logout') }}
                                </a>
                                <form action="{{ route('logout') }}" method="post" id="logout-form" class="d-none">
                                    @csrf</form>
                            </div>
                            @else
                            <div class="col-6 pt-3">

                            </div>
                            {{-- <div class="col-6">
                                <a href="{{ route('register') }}" class="text-white text-decoration-none">
                                    <i class="fas fa-user-plus"></i>
                                    تسجيل جديد
                                </a>
                            </div> --}}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-output">
            <div class="container header-in">
                <div class="row">
                    <div class="col-xl-2 col-lg-2">
                        <a id="logo" href="https://www.hrfactoryapp.com/" class="d-inline-block margin-top-20px">

                            <img src="{{ asset('assets/img/logo-1.png') }}" alt="" height="40">

                        </a>

                    </div>
                    <div class="col-xl-2 col-lg-2">
                    </div>
                    {{-- <div class="col-xl-4 col-lg-4 margin-tb-25px">
                        <div class="text-center">


                            <ul id="menu-main" class="text-c nav-menu dropdown-dark ">
                                <li>
                                    <a href="#" class="btn btn-acc blink_me" data-toggle="modal" data-target="#FreeSub">
                                        <h4>اشترك مجانا لمدة 7 أيام </h4>
                                    </a>

                                </li>
                            </ul>
                        </div>
                    </div> --}}

                    <div class="col-xl-4 col-lg-4">
                        <div class="float-lg-right margin-top-0px">
                            <ul id="menu-main" class="float-lg-left nav-menu dropdown-dark">
                                <li><a href="/">Home</a></li>
                                @if (Auth()->check())

                                @if (Auth()->user()->user_type == 'admin' ||Auth()->user()->user_type == 'superadmin')
                                <li><a href="{{ route('partner-ship-plans.index') }}">Control Panel</a> </li>
                                @endif
                                @endif
                                {{-- <li><a href="/TrainingHome#learnOnline">تعلم</a> </li>
                                <li><a href="/#consultHR">استشر</a> </li> --}}
                                {{-- <li><a href="/Home/AboutUs">About Us</a> </li> --}}

                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2">
                        {{-- <sup class="text-capitalize m-2">powered by</sup>
                        <a id="logo" href="https://www.hrfactoryapp.com/" class="d-inline-block margin-top-20px">

                            <img src="{{ asset('assets/img/logo-1.png') }}" alt="" height="40">

                        </a> --}}


                    </div>
                    {{--
                    <!-- // Social -->
                    <div class="col-xl-2 col-lg-2 padding-social">
                        <div class="d-none d-lg-block pull-right model-link">
                            <ul class="list-inline text-center margin-0px social">
                                <li class="list-inline-item"><a class="twitter cms" data-contentId="105"
                                        href="https://twitter.com/HRFactory4"><i class="fab fa-twitter"></i></a></li>
                                <li class="list-inline-item">
                                    <a class="youtube cms" data-contentId="106"
                                        href="https://www.instagram.com/hrfactoryapp/">
                                        <i class="fab fa-instagram"></i></a>
                                </li>
                                <li class="list-inline-item"><a class="linkedin cms" data-contentId="107"
                                        href="https://www.linkedin.com/company/hr-factory-app">
                                        <i class="fab fa-linkedin"></i></a></li>
                            </ul>

                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </header>
    <!-- // header -->

    @yield('content')

    <footer class="background-footer mt-1" dir="ltr" style="">
        <div class="container mt-1 pt-1 pb-1">
            <div class="row">
                <div class="col-8 col-lg-10 col-md-10 wow fadeInUp">
                    <div class="row">
                        {{-- <div class="col-6 logo margin-bottom-10px text-right">
                            <a id="logo" href="https://www.takatuf.om/en/" class="d-inline-block margin-top-20px">

                                <img src="{{ asset('assets/img/Takatuf-Logo.png') }}" alt="" width="100">

                            </a>

                        </div> --}}
                        <div class="col-6 logo margin-bottom-10px text-right">
                            <a id="logo" href="https://www.hrfactoryapp.com/" class="d-inline-block margin-top-20px"><img
                                    src="{{ asset('assets/img/logo.png') }}" height="50" alt=""></a>
                        </div>
                    </div>
                    <!-- // Social -->
                </div>
                <div class="col-4 col-lg-2 col-md-2 wow fadeInUp" data-wow-delay="0.2s">
                    <ul class="list-inline text-left margin-lr-0px text-white">
                        {{-- <li class="list-inline-item"><a class="twitter cms" data-contentId="105"
                                href="https://twitter.com/HRFactory4"><i class="fab fa-twitter"></i></a></li>
                        <li class="list-inline-item"><a class="youtube cms" data-contentId="106"
                                href="https://www.instagram.com/hrfactoryapp/"><i class="fab fa-instagram"></i></a>
                        </li>
                        <li class="list-inline-item"><a class="linkedin cms" data-contentId="107"
                                href="https://www.linkedin.com/company/hr-factory-app"><i
                                    class="fab fa-linkedin"></i></a></li> --}}
                        @if (!Auth::check())
                        <li class="list-inline-item"> <a href="{{ route('login') }}"
                                class="text-white text-decoration-none">
                                <i class=""></i>
                                {{ __('Login') }}
                            </a></li>
                        @endif

                    </ul>
                    <a class="text-white" href="{{-- tel:+96879178007 --}}" dir="ltr"><i class="fas fa-phone"></i>
                        {{-- &nbsp;
                        +968 7917 8007 --}}
                    </a><br />
                    <a class="text-white" href="{{-- mailto:care@hrfactoryapp.com --}}" dir="ltr"><i
                            class="fas fa-envelope"></i>&nbsp; {{-- care@hrfactoryapp.com --}}</a>
                </div>
            </div>
        </div>
    </footer>


    </div>



    <!--  <script type="text/javascript" src="~/assets/js/numscroller-1.0.js"></script> -->
    <script type="text/javascript" src="{{ asset('assets/js/sticky-sidebar.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/YouTubePopUp.jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/imagesloaded.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/wow.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/custom.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js" defer></script>

    <script>
        // $(".contentImage").on("click", function() {
        //     debugger;
        //     var currentSource = $(this).attr("src");
        //     $(this).uniqueId();
        //     var imageId = $(this).attr("Id");
        //     return;
        //     $.ajax({
        //         url: "/Home/ChangeImage",
        //         data: {
        //             currentSource: currentSource,
        //             imageId: imageId
        //         },
        //         sync: false,
        //         success: function(data) {
        //             $("#changeImageModalBody").html(data);
        //         },
        //         error: function(err, status, error) {
        //             debugger;
        //             toastr.error(err.statusText)
        //         },
        //     });
        //     $('#changeImageModal').modal('show');
        // });

        function showPss(control, id) {
            //console.log($('#'+control));
            var flage = false;
            var classList = $('#' + id).attr('class').split(/\s+/);
            $.each(classList, function(index, item) {
                if (item === 'fa-eye-slash') {
                    flage = true;
                }
            });
            if (flage) {
                $("#" + id).attr('class', "fa fa-eye");
                $("#" + control).prop("type", "text");
            } else {
                $("#" + id).attr('class', "fa fa-eye-slash");
                $("#" + control).prop("type", "password");
            }

        }
    </script>

    @yield('scripts')


</body>

</html>
