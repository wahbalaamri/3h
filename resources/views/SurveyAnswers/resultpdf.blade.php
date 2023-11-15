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
    @yield('style')
</head>

<body class="background-white">


    <!-- // header -->
    <div class="" dir="{{ App()->getLocale()=='ar'? 'rtl':'ltr' }}">
{{-- container --}}
<div class="container-fluid pt-5 mt-5">
    <div class="row justify-content-center">

        <div class="col-10" id="finalResult">

            {{--card for dashboard result--}}
            <div class="card shadow p-3 mb-5 bg-white rounded">
                {{-- header --}}
                <div class="card-header">
                    <h2 class="card-title">
                        {{-- color text orange with later spacing 1 --}}
                        <span class="text-orange space-x-6">
                            {{ __('Dashboard-')}}{{ $term }}
                        </span>
                    </h2>
                </div>
                {{-- body --}}
                <div class="card-body">
                    {{-- row with three columns idintical --}}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card bg-light p-3 mb-3 rounded">
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
                                    <div class="row d-flex justify-content-center align-items-center text-center">
                                        <div class="col-12">
                                            <div class="speedometer
                                            @if ($EE_Index<=25)
                                            speed-1
                                            @elseif($EE_Index<=50)
                                            speed-2
                                            @elseif($EE_Index<=65)
                                            speed-3
                                            @elseif($EE_Index<=80)
                                            speed-4
                                            @else
                                            speed-5
                                            @endif
                                            ">
                                                <div class="pointer"></div>
                                            </div>
                                            <h3 class="caption">{{ $EE_Index }}%</h3>
                                        </div>
                                        <div class="col-12 mt-5">
                                            <div class="row">
                                                <div class="col-md-4 col-sm-12">
                                                    <div class="custom-progress mb-3">
                                                        <div class="custom-progress-bar bg-success @if ($EE_Index_Engaged <=0)
                                                        text-danger
                                                    @endif" style="height:{{ $EE_Index_Engaged }}%">
                                                            <span>{{ $EE_Index_Engaged }}%</span>
                                                        </div>
                                                    </div>
                                                    <span class="caption h6">{{ __('Engaged') }}</span>
                                                </div>
                                                <div class="col-md-4 col-sm-12">
                                                    <div class="custom-progress mb-3">
                                                        <div class="custom-progress-bar bg-warning @if ($EE_Index_Nuetral<=0) text-danger @endif"
                                                            style="height:{{ $EE_Index_Nuetral }}%">
                                                            <span>{{ $EE_Index_Nuetral }}%</span>
                                                        </div>
                                                    </div>
                                                    <span class="caption h6">{{ __('Nuetral') }}</span>
                                                </div>
                                                <div class="col-md-4 col-sm-12">
                                                    <div class="custom-progress mb-3">
                                                        <div class="custom-progress-bar bg-danger @if ($EE_Index_Actively_Disengaged<=0)
                                                        text-danger
                                                    @endif" style="height:{{ $EE_Index_Actively_Disengaged }}%">
                                                            <span>{{ $EE_Index_Actively_Disengaged
                                                                }}%</span>
                                                        </div>
                                                    </div>
                                                    <span class="caption h6">{{ __('Actively Disengaged') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
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
                                        @foreach ($overall_per_fun as $fun)
                                        <div class="col-12">
                                            <div class="caption">
                                                <h3 class="h3">{{ $fun['fun_title'] }}</h3>
                                                {{-- <h5 class="h6">({{ $fun['fun_des'] }})</h5> --}}
                                            </div>
                                            <div class="speedometer
                                            @if ($fun['fun_perc']<=25)
                                            speed-1
                                            @elseif($fun['fun_perc']<=50)
                                            speed-2
                                            @elseif($fun['fun_perc']<=65)
                                            speed-3
                                            @elseif($fun['fun_perc']<=85)
                                            speed-4
                                            @else
                                            speed-5
                                            @endif
                                            ">
                                                <div class="pointer"></div>
                                            </div>
                                            <h3 class="caption">{{ $fun['fun_perc'] }}%</h3>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light p-3 mb-3 rounded">
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
                                    <div class="row d-flex justify-content-center align-items-center text-center">
                                        <div class="col-12">
                                            <div class="speedometer
                                            @if ($eNPS<=25)
                                            speed-1
                                            @elseif($eNPS<=50)
                                            speed-2
                                            @elseif($eNPS<=65)
                                            speed-3
                                            @elseif($eNPS<=85)
                                            speed-4
                                            @else
                                            speed-5
                                            @endif
                                            ">
                                                <div class="pointer"></div>
                                            </div>
                                            <h3 class="caption">{{ $eNPS }}%</h3>
                                        </div>
                                        <div class="col-12 mt-5">
                                            <div class="row">
                                                <div class="col-md-4 col-sm-12">
                                                    <div class="custom-progress mb-3">
                                                        <div class="custom-progress-bar bg-success @if ($eNPS_Promotors<=0)
                                                            text-danger
                                                        @endif" style="height:{{ $eNPS_Promotors }}%">
                                                            <span>{{ $eNPS_Promotors }}%</span>
                                                        </div>
                                                    </div>
                                                    <span class="caption h6">{{ __('Promotors')}}</span>
                                                </div>
                                                <div class="col-md-4 col-sm-12">
                                                    <div class="custom-progress mb-3">
                                                        <div class="custom-progress-bar bg-warning @if ($eNPS_Passives<=0)
                                                        text-danger
                                                    @endif" style="height:{{ $eNPS_Passives }}%">
                                                            <span>{{ $eNPS_Passives }}%</span>
                                                        </div>
                                                    </div>
                                                    <span class="caption h6 pt-3">{{ __('Passives') }}</span>
                                                </div>
                                                <div class="col-md-4 col-sm-12">
                                                    <div class="custom-progress mb-3">
                                                        <div class="custom-progress-bar bg-danger @if ($eNPS_Detractors<=0)
                                                        text-danger
                                                    @endif" style="height:{{ $eNPS_Detractors }}%">
                                                            <span>{{ $eNPS_Detractors }}%</span>
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
                    </div>
                </div>
            </div>
            {{-- card for Engagement Drivers Result-Organizational Wide --}}
            <div class="card shadow p-3 mb-5 bg-white rounded">
                {{-- header --}}
                <div class="card-header d-flex align-items-center">
                    <h2 class="h4 text-orange">{{ __('Engagement Drivers Result - ')}}{{ $term }}</h2>
                </div>
                {{-- body --}}
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 pt-5 pb-5 bg-info shadow p-3 rounded">
                            <h3 class="text-white">{{ __('Engagement Drivers') }}</h3>
                        </div>
                    </div>
                    <div class="row">
                        @foreach ( $overall_per_fun as $fun_result)

                        <div class="col-md-4 col-sm-12">
                            <div class="card-header d-flex align-items-center pt-3 text-center">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="caption">
                                                    <h3 class="h3">{{ $fun_result['fun_title'] }}</h3>
                                                    {{-- <h5 class="h5">({{ $fun_result['fun_des'] }})</h5> --}}
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="speedometer
                                            @if ($fun_result['fun_perc']<=25)
                                            speed-1
                                            @elseif($fun_result['fun_perc']<=50)
                                            speed-2
                                            @elseif($fun_result['fun_perc']<=65)
                                            speed-3
                                            @elseif($fun_result['fun_perc']<=85)
                                            speed-4
                                            @else
                                            speed-5
                                            @endif
                                            ">
                                                    <div class="pointer"></div>
                                                </div>
                                                <h3 class="caption">{{ $fun_result['fun_perc'] }}%</h3>
                                            </div>
                                            @foreach ($overall_per_practice as $practice)
                                            @if ($practice['FunctionId']==$fun_result['fun_id'])

                                            <div class="col-12 pt-2 pb-2 text-center mb-2 rounded
                                            @if ($practice['practice_perc']<=54)
                                                bg-danger text-white
                                            @elseif($practice['practice_perc']<=74)
                                                bg-warning
                                                @else
                                                bg-success text-white
                                            @endif
                                            ">
                                                {{ $practice['PracticeTitle'] }} {{-- -- {{ $practice['practice_perc']
                                                }} --}}
                                            </div>
                                            @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            {{-- card for Top and Bottom Scores-Organizational Wide --}}
            <div class="card shadow p-3 mb-5 bg-white rounded">
                {{-- header --}}
                <div class="card-header d-flex align-items-center">
                    <h2 class="h4 text-orange">{{ __('Top and Bottom Scores - ')}}{{ $term }}.
                    </h2>
                </div>
                {{-- body --}}

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            {{-- card --}}
                            <div class="card p-3 mb-5 rounded">
                                {{-- header --}}
                                <div class="card-header d-flex align-items-center bg-info">
                                    <h3 class="h3 text-white">{{ __('Key Strengths') }}</h3>
                                </div>
                                {{-- body --}}
                                <div class="card-body">
                                    <div class="row">
                                        @foreach ($highest_practices as $parctice)

                                        <div class="col-12">
                                            <span class="caption"> {{ $parctice['PracticeTitle']
                                                }}</span>
                                            <div class="progress" role="progressbar" aria-label="Warning example"
                                                aria-valuenow="{{  $parctice['practice_perc'] }}" aria-valuemin="0"
                                                aria-valuemax="100" style="height: 20px">
                                                <div class="progress-bar
                                                @if ($parctice['practice_perc']>=75)
                                                text-bg-success
                                                @elseif ($parctice['practice_perc']>=55)
                                                text-bg-warning
                                                @else
                                                text-bg-danger
                                                @endif
                                                "
                                                    style="width: {{  $parctice['practice_perc'] }}% ; font-size: 0.9rem;">
                                                    {{
                                                    $parctice['practice_perc'] }}%</div>
                                            </div>

                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            {{-- card --}}
                            <div class="card p-3 mb-5 rounded">
                                {{-- header --}}
                                <div class="card-header d-flex align-items-center bg-info">
                                    <h3 class="h3 text-white">{{ __('Key Improvement Areas') }}</h3>
                                </div>
                                {{-- body --}}
                                <div class="card-body">
                                    <div class="row">
                                        @foreach ($lowest_practices as $parctice)

                                        <div class="col-12">
                                            <span class="caption"> {{ $parctice['PracticeTitle']
                                                }}</span>
                                            <div class="progress" role="progressbar" aria-label="Warning example"
                                                aria-valuenow="{{  $parctice['practice_perc'] }}" aria-valuemin="0"
                                                aria-valuemax="100" style="height: 20px">
                                                <div class="progress-bar
                                                @if ($parctice['practice_perc']>=75)
                                                text-bg-success
                                                @elseif ($parctice['practice_perc']>=55)
                                                text-bg-warning
                                                @else
                                                text-bg-danger
                                                @endif
                                                "
                                                    style="width: {{  $parctice['practice_perc'] }}% ; font-size: 0.9rem;">
                                                    {{
                                                    $parctice['practice_perc'] }}%</div>
                                            </div>

                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            {{--
                            ===========================================================================
                            --}}
                        </div>
                    </div>
                </div>
            </div>
            @if(!$isDep)
            {{-- card for Heat Map-Engagement Drivers Result across Sectors --}}
            <div class="card shadow p-3 mb-5 bg-white rounded">
                {{-- header --}}
                <div class="card-header d-flex align-items-center">
                    <h2 class="h4 text-orange">{{ __('Heat Map - Engagement Drivers Result across ') }}{{ $term1 }}</h2>
                </div>
                {{-- body --}}
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-active table-bordered" aria-colspan="2">
                            <thead>
                                <tr class="text-center">
                                    <th class="bg-info">{{ __($term2) }}</th>
                                    <th class="bg-info">{{
                                        App()->getLocale()=='ar'?$driver_functions[0]->FunctionTitleAr:$driver_functions[0]->FunctionTitle
                                        }}</th>
                                    <th class="bg-info">{{
                                        App()->getLocale()=='ar'?$driver_functions[1]->FunctionTitleAr:$driver_functions[1]->FunctionTitle
                                        }}</th>
                                    <th class="bg-info">{{
                                        App()->getLocale()=='ar'?$driver_functions[2]->FunctionTitleAr:$driver_functions[2]->FunctionTitle
                                        }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ( $result_per_sector as $Sect_data)
                                <tr>
                                    <td class="text-center bg-info">{{ $Sect_data['sector_name'] }}</td>

                                    @foreach ($Sect_data['functions'] as $sect_fun)
                                    @if($sect_fun['fun_id']==$driver_functions[0]->id)
                                    <td class="text-center
                                    @if ($sect_fun['sect_perc']>=75)
                                        bg-success
                                        @elseif ($sect_fun['sect_perc']>=55)
                                        bg-warning
                                    @else
                                    bg-danger
                                    @endif">
                                        {{ $sect_fun['sect_perc'] }}%
                                    </td>
                                    @break
                                    @endif
                                    @endforeach
                                    @foreach ($Sect_data['functions'] as $sect_fun)
                                    @if($sect_fun['fun_id']==$driver_functions[1]->id)
                                    <td class="text-center
                                    @if ($sect_fun['sect_perc']>=75)
                                        bg-success
                                        @elseif ($sect_fun['sect_perc']>=55)
                                        bg-warning
                                    @else
                                    bg-danger
                                    @endif">
                                        {{ $sect_fun['sect_perc'] }}%
                                    </td>
                                    @break
                                    @endif
                                    @endforeach
                                    @foreach ($Sect_data['functions'] as $sect_fun)
                                    @if($sect_fun['fun_id']==$driver_functions[2]->id)
                                    <td class="text-center
                                    @if ($sect_fun['sect_perc']>=75)
                                        bg-success
                                        @elseif ($sect_fun['sect_perc']>=55)
                                        bg-warning
                                    @else
                                    bg-danger
                                    @endif">
                                        {{ $sect_fun['sect_perc'] }}%
                                    </td>
                                    @break
                                    @endif
                                    @endforeach

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

        </div>
        {{-- =============================================================== --}}
    </div>
</div>
</div>


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
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
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
<script>
    var survey_id="{{ $survey_id }}"
    $("#sector").change(function(){
if($("#sector").val()!='')
{
    $.ajax({
                type:"GET",
                url:"{{ url('companies/getForSelect') }}/"+$("#sector").val(),
                success:function(res){
                    if(res){
                        $("#company").empty();
                        $("#company").append('<option value="">{{ __("Select Company") }}</option>');
                        $.each(res,function(key,value){
                            $("#company").append('<option value="'+value.id+'">'+value.company_name_en+'</option>');
                        });
                    }else{
                        $("#company").empty();
                    }
                }
            });
    // GetSectorData companyDiv
    $('#companyDiv').show();
    $('#GetSectorData').show();
    //set href for GetSector
    $('#GetSector').attr('href','{{ url("/survey-answers/SectorResult/") }}/'+survey_id+'/'+$("#sector").val());
}
else{
    $('#GetSectorData').hide();
    $('#companyDiv').hide();
    $('#GetCompData').hide();
    $('#departmentDiv').hide();
    $('#GetDepData').hide();
}
});
    $("#company").change(function(){
if($("#company").val()!='')
{
    $.ajax({
                type:"GET",
                url:"{{ url('departments/getForSelect') }}/"+$("#company").val(),
                success:function(res){
                    if(res){
                        $("#Department").empty();
                        $("#Department").append('<option value="">{{ __("Select Department") }}</option>');
                        $.each(res,function(key,value){
                            $("#Department").append('<option value="'+value.id+'">'+value.dep_name_en+'</option>');
                        });
                    }else{
                        $("#Department").empty();
                    }
                }
            });

    // GetSectorData companyDiv

    $('#departmentDiv').show();
    $('#GetCompData').show();
    //set href for GetCompany
    $('#GetCompany').attr('href','{{ url("/survey-answers/CompanyResult/") }}/'+survey_id+'/'+$("#company").val());
}else{
    $('#GetCompData').hide();
    $('#departmentDiv').hide();
    $('#GetDepData').hide();
}
});
$("#Department").change(function(){
    if($("#Department").val()!='')
{
    $('#GetDepData').show();
    //set href for GetDep
    $('#GetDep').attr('href','{{ url("/survey-answers/DepartmentResult/") }}/'+survey_id+'/'+$("#Department").val());
}
else{
    $('#GetDepData').hide();
}
});
</script>

</body>

</html
