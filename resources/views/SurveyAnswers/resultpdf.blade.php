{{-- extends --}}
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
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">


    <!-- animate -->
    <link href="{{ public_path('assets/css/animate.css') }}">

    <!-- owl Carousel assets -->
    <link href="{{ public_path('assets/css/owl.carousel.css') }}">


    <link href="{{ public_path('assets/css/owl.theme.css') }}">


    <!-- bootstrap -->
    <link href="{{ public_path('assets/css/bootstrap.min.css') }}">

    <!-- hover anmation -->
    <link href="{{ public_path('assets/css/hover-min.css') }}">
    <!-- <link rel="stylesheet" href="~/assets/css/hover-min.css"> -->
    <!-- flag icon -->
    <link href="{{ public_path('assets/css/flag-icon.min.css') }}">
    <!-- <link rel="stylesheet" href="~/assets/css/flag-icon.min.css"> -->

    <!-- main style -->
    <link href="{{ public_path('assets/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ public_path('assets/css/style.css') }}">
    <!-- colors -->
    <link href="{{ public_path('assets/css/colors/main.css') }}">
    <!-- <link rel="stylesheet" href="~/assets/css/colors/main.css"> -->
    <!-- elegant icon -->
    <link href="{{ public_path('assets/css/elegant_icon.css') }}">
    <!-- <link rel="stylesheet" href="~/assets/css/elegant_icon.css"> -->
    <!-- jquery  UI style  -->
    <link href="{{ public_path('assets/Content/themes/base/jquery-ui.css') }}">
    <!-- <link href="~Content/themes/base/jquery-ui.css" rel="stylesheet" /> -->
    <link href="{{ public_path('assets/Content/themes/base/jquery-ui.min.css') }}">
    <!-- <link href="~assets/Content/themes/base/jquery-ui.min.css" rel="stylesheet" /> -->
    <!-- jquery library  -->
    <script type="text/javascript" src="{{ public_path('assets/js/jquery-3.2.1.min.js') }}"></script>
    <!-- jquery UI library  -->
    <script src="{{ public_path('assets/Scripts/jquery-ui-1.13.0.js') }}"></script>
    <script src="{{ public_path('assets/Scripts/jquery-ui-1.13.0.min.js') }}"></script>
    <!-- fontawesome  -->
    <script src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
    <!-- google maps api  -->


    <script src="{{ public_path('assets/Scripts/jquery-gauge.min.js') }}"></script>
    <script src="{{ public_path('assets/Scripts/toastr.min.js') }}"></script>
    <link href="{{ public_path('assets/Content/jquery-gauge.css') }}" as="style" onload="this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="{{ public_path('assets/Content/jquery-gauge.css') }}">
    </noscript>
    <!-- <link href="~/Content/jquery-gauge.css" rel="stylesheet" /> -->
    <link href="{{ public_path('assets/Content/toastr.css') }}" as="style" onload="this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="{{ public_path('assets/Content/toastr.css') }}">
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
    <script src="{{ public_path('assets/Scripts/jquery.blockUI.js') }}"></script>
    @vite(['resources/js/app.js'])
    @stack('styles')
    @yield('style')
</head>

<body class="background-white">


    <!-- // header -->
    <div class="" dir="{{ App()->getLocale()=='ar'? 'rtl':'ltr' }}">
        {{-- container --}}
        <div class="container-fluid pt-5 mt-5">
            <div class="row justify-content-center">

                <div class="col-10" id="finalResult">
                    <div class="card">
                        {{-- header --}}
                        <div class="card-header">
                            <div class="d-flex text-start">
                                <h3 class="card-title text-black">@if($type=='comp'){{
                                    __('Company-wise') }} | {{ $entity }}
                                    @elseif ($type=='sec')
                                    {{__('Sector-wise') }} | {{ $entity }}
                                    @else
                                    {{__('Corporation-wise') }} | {{ $entity }}
                                    @endif</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            {{-- row with three columns idintical --}}
                            <div class="row">
                                <div
                                    class="col-lg-5 col-md-12 col-sm-12 pl-5 pr-5 d-flex align-items-stretch margin-right-52px justify-content-center">
                                    <div class="card bg-light p-3 mb-3 rounded w-75">
                                        {{-- header with blue background --}}
                                        <div class="card-header bg-info">
                                            {{-- centerlize items --}}
                                            <div class="d-flex justify-content-center align-items-center">
                                                <h3 class="card-title text-white text-center pt-4 pb-4">{{
                                                    __('Employee Engagement Index') }}</h3>
                                            </div>
                                        </div>
                                        {{-- body --}}
                                        <div class="card-body">
                                            <div
                                                class="row d-flex justify-content-center align-items-center text-center">
                                                <div class="col-12">
                                                    <div class="speedometer
                                        @if ($outcomes[0]['outcome_index']<=25)
                                        speed-1
                                        @elseif($outcomes[0]['outcome_index']<60)
                                        speed-2
                                        @elseif($outcomes[0]['outcome_index']<=65)
                                        speed-3
                                        @elseif($outcomes[0]['outcome_index']<70)
                                        speed-4
                                        @else
                                        speed-5
                                        @endif
                                        ">
                                                        <div class="pointer"></div>
                                                    </div>
                                                    <h3 class="caption">{{ $outcomes[0]['outcome_index'] }}%</h3>
                                                </div>
                                                <div class="col-12 mt-5">
                                                    <div class="row">
                                                        <div class="col-sm-4 col-xs-12 progress-container">
                                                            <div class="custom-progress mb-3">
                                                                <div class="custom-progress-bar bg-success @if ($outcomes[0]['Favorable_score'] <=0)
                                                    text-danger
                                                @endif" style="height:{{ $outcomes[0]['Favorable_score'] }}%">
                                                                    <span>{{ $outcomes[0]['Favorable_score'] }}%</span>
                                                                </div>
                                                            </div>
                                                            <span class="caption h6">{{ __('Engaged') }}</span>
                                                        </div>
                                                        <div class="col-sm-4 col-xs-12 progress-container">
                                                            <div class="custom-progress mb-3">
                                                                <div class="custom-progress-bar bg-warning @if ($outcomes[0]['Nuetral_score']<=0) text-danger @endif"
                                                                    style="height:{{ $outcomes[0]['Nuetral_score'] }}%">
                                                                    <span>{{ $outcomes[0]['Nuetral_score'] }}%</span>
                                                                </div>
                                                            </div>
                                                            <span class="caption h6">{{ __('Nuetral') }}</span>
                                                        </div>
                                                        <div class="col-sm-4 col-xs-12 progress-container">
                                                            <div class="custom-progress mb-3">
                                                                <div class="custom-progress-bar bg-danger @if ($outcomes[0]['UnFavorable_score']<=0)
                                                    text-danger
                                                @endif" style="height:{{ $outcomes[0]['UnFavorable_score'] }}%">
                                                                    <span>{{ $outcomes[0]['UnFavorable_score']
                                                                        }}%</span>
                                                                </div>
                                                            </div>
                                                            <span class="caption h6">{{ __('Actively Disengaged')
                                                                }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                @if($ENPS_data_array)
                                <div
                                    class="col-lg-5 col-md-12 col-sm-12 pl-5 pr-5 d-flex align-items-stretch margin-right-52px justify-content-center">
                                    <div class="card bg-light p-3 mb-3 rounded w-75">
                                        {{-- header with blue background --}}
                                        <div class="card-header bg-info">
                                            {{-- centerlize items --}}
                                            <div class="d-flex justify-content-center align-items-center">
                                                <h3 class="card-title text-white text-center pt-2 pb-2">{{
                                                    __('Employee Net Promotor Score (eNPS)') }}</h3>
                                            </div>
                                        </div>
                                        {{-- body --}}
                                        <div class="card-body">
                                            <div
                                                class="row d-flex justify-content-center align-items-center text-center">
                                                <div class="col-12">
                                                    <div class="speedometer
                                            @if ($ENPS_data_array['ENPS_index']<=25)
                                            speed-1
                                            @elseif($ENPS_data_array['ENPS_index']<60)
                                            speed-2
                                            @elseif($ENPS_data_array['ENPS_index']<=65)
                                            speed-3
                                            @elseif($ENPS_data_array['ENPS_index']<70)
                                            speed-4
                                            @else
                                            speed-5
                                            @endif
                                            ">
                                                        <div class="pointer"></div>
                                                    </div>
                                                    <h3 class="caption">{{ $ENPS_data_array['ENPS_index'] }}%</h3>
                                                </div>
                                                <div class="col-12 mt-5">
                                                    <div class="row">
                                                        <div class="col-sm-4 col-xs-12 progress-container">
                                                            <div class="custom-progress mb-3">
                                                                <div class="custom-progress-bar bg-success @if ($ENPS_data_array['Favorable_score']<=0)
                                                            text-danger
                                                        @endif" style="height:{{ $ENPS_data_array['Favorable_score'] }}%">
                                                                    <span>{{ $ENPS_data_array['Favorable_score']
                                                                        }}%</span>
                                                                </div>
                                                            </div>
                                                            <span class="caption h6">{{ __('Promotors')}}</span>
                                                        </div>
                                                        <div class="col-sm-4 col-xs-12 progress-container">
                                                            <div class="custom-progress mb-3">
                                                                <div class="custom-progress-bar bg-warning @if ($ENPS_data_array['Nuetral_score']<=0)
                                                        text-danger
                                                    @endif" style="height:{{ $ENPS_data_array['Nuetral_score'] }}%">
                                                                    <span>{{ $ENPS_data_array['Nuetral_score']
                                                                        }}%</span>
                                                                </div>
                                                            </div>
                                                            <span class="caption h6 pt-3">{{ __('Passives') }}</span>
                                                        </div>
                                                        <div class="col-sm-4 col-xs-12 progress-container">
                                                            <div class="custom-progress mb-3">
                                                                <div class="custom-progress-bar bg-danger @if ($ENPS_data_array['UnFavorable_score']<=0)
                                                        text-danger
                                                    @endif" style="height:{{ $ENPS_data_array['UnFavorable_score'] }}%">
                                                                    <span>{{ $ENPS_data_array['UnFavorable_score']
                                                                        }}%</span>
                                                                </div>
                                                            </div>
                                                            <span class="caption h6 pt-3">{{ __('Detractors')
                                                                }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="row">
                                <div class="card bg-light p-3 mb-3 rounded">
                                    {{-- header with blue background --}}
                                    <div class="card-header bg-info">
                                        {{-- centerlize items --}}
                                        <div class="d-flex justify-content-center align-items-center">
                                            <h3 class="card-title text-white text-center pt-4 pb-4">{{
                                                __('Employee Engagement Drivers') }}</h3>
                                        </div>
                                    </div>
                                    {{-- body --}}
                                    <div class="card-body">
                                        <div class="row d-flex justify-content-center align-items-center text-center">
                                            @foreach ($drivers_functions as $function)
                                            <div class="col-md-4 col-sm-12">
                                                <div class="caption">
                                                    <h3 class="h3">{{ $function['function_title'] }}</h3>
                                                    {{-- <h5 class="h6">({{ $fun['fun_des'] }})</h5> --}}
                                                </div>
                                                <div class="speedometer
                                        @if ($function['Favorable_score']<=25)
                                        speed-1
                                        @elseif($function['Favorable_score']<60)
                                        speed-2
                                        @elseif($function['Favorable_score']<=65)
                                        speed-3
                                        @elseif($function['Favorable_score']<70)
                                        speed-4
                                        @else
                                        speed-5
                                        @endif
                                        ">
                                                    <div class="pointer"></div>
                                                </div>
                                                <h3 class="caption">{{ $function['Favorable_score'] }}%</h3>
                                                @foreach ($drivers as $practice)
                                                @if ($practice['function']==$function['function'])

                                                <div class="col-12 pt-2 pb-2 text-center mb-2 rounded
                                            @if ($practice['Favorable_score']<=54)
                                                bg-danger text-white
                                            @elseif($practice['Favorable_score']<=74)
                                                bg-warning
                                                @else
                                                bg-success text-white
                                            @endif
                                            ">
                                                    {{ $practice['practice_title'] }} -- {{ $practice['Favorable_score']
                                                    }}
                                                </div>
                                                @endif
                                                @endforeach
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- end of card --}}

                </div>
            </div>
            {{-- =============================================================== --}}
        </div>
    </div>




    <!--  <script type="text/javascript" src="~/assets/js/numscroller-1.0.js"></script> -->
    <script type="text/javascript" src="{{ public_path('assets/js/sticky-sidebar.js') }}"></script>
    <script type="text/javascript" src="{{ public_path('assets/js/YouTubePopUp.jquery.js') }}"></script>
    <script type="text/javascript" src="{{ public_path('assets/js/owl.carousel.min.js') }}"></script>
    <script type="text/javascript" src="{{ public_path('assets/js/imagesloaded.min.js') }}"></script>
    <script type="text/javascript" src="{{ public_path('assets/js/wow.min.js') }}"></script>
    <script type="text/javascript" src="{{ public_path('assets/js/custom.js') }}"></script>
    <script type="text/javascript" src="{{ public_path('assets/js/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ public_path('assets/js/bootstrap.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>


</body>

</html
