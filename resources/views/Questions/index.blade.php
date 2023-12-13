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
    {{-- @stack('styles')
    @yield('style') --}}
</head>

<body class="background-white">


    <!-- header -->
    <header class="gradient-white box-shadow">
        <div class="background-grey-2 padding-tb-5px position-relative">
            <div class="container" style="max-width: 98%">
                <div class="row">
                    <div class="col-6 text-white float-start">
                        @if( app()->getLocale()=='en')
                        <a class="text-white" href="{{ route('lang.swap','ar') }}"
                            style="text-decoration: none">العربية</a>
                        @else
                        <a class="text-white" href="{{ route('lang.swap','en') }}"
                            style="text-decoration: none">English</a>
                        @endif
                    </div>
                    <div class="col-6 text-white text-end">
                        <div class="row">
                            <div class="col-6"></div>
                            {{-- login or logout --}}
                            @if (Auth::check())
                            <div class="col-3">
                                <a href="{{ route('users.changePassword',auth()->user()->id) }}"
                                    class="text-white text-decoration-none">
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

                            <img src="{{ asset('assets/img/logo-1.png') }}" alt="" height="">

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

                    <div class="col-xl-4 col-lg-4 d-flex" dir="{{ App()->getLocale()=='ar'?'rtl':'ltr' }}">
                        <div class="float-start margin-top-0px">
                            <ul id="menu-main" class="float-start nav-menu dropdown-dark">
                                <li><a href="/" class="menu-li-iteam" {{-- style="margin-right:1rem !important" --}}>{{
                                        __('Home') }}</a></li>
                                @if (Auth()->check())

                                @if (Auth()->user()->user_type == 'admin' ||Auth()->user()->user_type == 'superadmin')
                                <li><a href="{{ route('partner-ship-plans.index') }}" class="menu-li-iteam" {{--
                                        style="margin-right:1rem !important" --}}>{{ __('Control Panel') }}</a>
                                </li>
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

                </div>
            </div>
        </div>
    </header>
    <!-- // header -->
    <div class="" dir="{{ App()->getLocale()=='ar'? 'rtl':'ltr' }}">
        <div class="container-fluid">
            {{--
            =====================================================================================================================
            --}}

            {{-- add card --}}
            <div class="row justify-content-center">
                <div class="col-sm-12">
                    <div class="card">
                        {{-- card header --}}
                        <div class="card-header text-center">
                            <div class="row">
                                <div class="col-md-9 col-sm-12">
                                    <h3>{{__('Please read the following statements and indicate your agreement')}}</h3>
                                </div>
                                <div class="col-md-3 col-sm-12">

                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#Language">
                                        {{ __('Change Language') }}
                                    </button>

                                </div>
                            </div>
                        </div>
                        {{-- card body --}}
                        <div class="card-body">

                            <div class="row justify-content-center">
                                <div class="col-12">
                                    <form action="{{ route('survey.generateSurveyUrl') }}" method="POST"
                                        data-bs-multi-step-form>
                                        @csrf
                                        <div class="progressbar">
                                            <div class="progress" id="progress"></div>

                                            <div class="progress-step stpactive" data-title="Intro"></div>
                                            @foreach ($functions as $function)
                                            <div class="progress-step" data-title="@if (str_contains($function->FunctionTitle,'Head') || str_contains($function->FunctionTitle,'Hand') || str_contains($function->FunctionTitle,'Heart'))
                                            H{{ $loop->iteration }}
                                            @else
                                            3h
                                            @endif">
                                            </div>
                                            @endforeach
                                            @if (count($open_end_q)>0)
                                            <div class="progress-step" data-title="{{ __('Open Ended Question')}}">
                                            </div>
                                            @endif
                                            {{-- <div class="progress-step" data-title="Contact"></div>
                                            <div class="progress-step" data-title="ID"></div>
                                            <div class="progress-step" data-title="Password"></div>
                                            <div class="progress-step" data-title="dddd"></div> --}}
                                        </div>
                                        <div class="my-wizard-continar active">
                                            <fieldset>
                                                <legend class="mb-5 pb-5 mt-5 pt-5">{{ __('Select Your Gender:') }}
                                                </legend>
                                                <div class="container-rad mb-5 pb-5 mt-5 pt-5">
                                                    <div class="radio-tile-group">

                                                        <div class="input-container">
                                                            <input id="gender" type="radio" name="gender" value="m">
                                                            <div class="radio-tile">
                                                                <i class="fa-solid fa-mars"></i>
                                                                <label for="gender">{{ __('Male') }}</label>
                                                            </div>
                                                        </div>

                                                        <div class="input-container">
                                                            <input id="gender" type="radio" name="gender" value="f">
                                                            <div class="radio-tile">
                                                                <i class="fa-solid fa-venus"></i>
                                                                <label for="gender">{{ __('Female') }}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <fieldset>
                                                <legend class="mb-5 pb-5 mt-5 pt-5">{{ __('What is your age group?') }}
                                                </legend>
                                                <div class="container-rad mb-5 pb-5 mt-5 pt-5">
                                                    <div class="radio-tile-group">

                                                        <div class="input-container">
                                                            <input id="agegroup" type="radio" name="agegroup" value="1">
                                                            <div class="radio-tile justify-content-center text-center">
                                                                {{-- <i class="fa-regular fa-face-angry"></i> --}}
                                                                <label for="agegroup">{{ __('26 or Below') }}</label>
                                                            </div>
                                                        </div>

                                                        <div class="input-container">
                                                            <input id="agegroup" type="radio" name="agegroup" value="2">
                                                            <div class="radio-tile justify-content-center text-center">
                                                                {{-- <i class="fa-regular fa-face-frown-open"></i> --}}
                                                                <label for="agegroup">{{ __('27 - 42') }}</label>
                                                            </div>
                                                        </div>

                                                        <div class="input-container">
                                                            <input id="agegroup" type="radio" name="agegroup" value="3">
                                                            <div class="radio-tile justify-content-center text-center">
                                                                {{-- <i class="fa-regular fa-face-meh"></i> --}}
                                                                <label for="agegroup">{{ __('43 - 58') }}</label>
                                                            </div>
                                                        </div>
                                                        <div class="input-container">
                                                            <input id="agegroup" type="radio" name="agegroup" value="4">
                                                            <div class="radio-tile justify-content-center text-center">
                                                                {{-- <i class="fa-regular fa-face-smile"></i> --}}
                                                                <label for="agegroup">{{ __('Above 58') }}</label>
                                                            </div>
                                                        </div>

                                                        {{-- <div class="input-container">
                                                            <input id="agegroup" type="radio" name="agegroup">
                                                            <div class="radio-tile justify-content-center text-center">
                                                                --}}
                                                                {{-- <i class="fa-regular fa-face-smile-beam"></i> --}}
                                                                {{-- <label for="agegroup">Fly</label>
                                                            </div>
                                                        </div> --}}

                                                    </div>
                                                </div>
                                            </fieldset>
                                            <div class="btnwxsc">
                                                <a href="javascript:void(0)"
                                                    class="btn btn-primary {{ app()->getLocale()=='ar'? 'float-start':'float-end'}} mt-5"
                                                    data-bs-next>{{
                                                    __('Next')
                                                    }}

                                                </a>
                                            </div>
                                        </div>
                                        @foreach ( $functions as $function )

                                        <div class="my-wizard-continar">
                                            @foreach ($function->functionPractices as $practice)

                                            <fieldset>
                                                <legend class="mb-5 pb-5 mt-5 pt-5">{{ $loop->iteration
                                                    }}.@if(app()->getLocale()=='en')
                                                    {{$practice->practiceQuestions->Question }}
                                                    @elseif (app()->getLocale()=='ar')
                                                    {{$practice->practiceQuestions->QuestionAr }}
                                                    @elseif (app()->getLocale()=='in')
                                                    {{$practice->practiceQuestions->QuestionIn }}
                                                    @endif
                                                </legend>
                                                <div class="container-rad mb-5 pb-5 mt-5 pt-5">
                                                    <div class="radio-tile-group">

                                                        <div class="input-container text-center">
                                                            <input id="survey" type="radio"
                                                                name="survey-{{ $practice->practiceQuestions->id }}"
                                                                value="1"
                                                                class="{{ app()->getLocale()=='ar'?'right-input-margin':'left-input-margin' }}">
                                                            <div class="radio-tile">
                                                                <i class="fa-regular fa-face-angry"></i>
                                                                <label for="survey">{{ __('Strongly Disagree')
                                                                    }}</label>
                                                            </div>
                                                        </div>

                                                        <div class="input-container text-center">
                                                            <input id="survey" type="radio"
                                                                name="survey-{{ $practice->practiceQuestions->id }}"
                                                                value="2"
                                                                class="{{ app()->getLocale()=='ar'?'right-input-margin':'left-input-margin' }}">
                                                            <div class="radio-tile">
                                                                <i class="fa-regular fa-face-frown-open"></i>
                                                                <label for="survey">{{ __('Disagree') }}</label>
                                                            </div>
                                                        </div>

                                                        <div class="input-container text-center">
                                                            <input id="survey" type="radio"
                                                                name="survey-{{ $practice->practiceQuestions->id }}"
                                                                value="3"
                                                                class="{{ app()->getLocale()=='ar'?'right-input-margin':'left-input-margin' }}">
                                                            <div class="radio-tile">
                                                                <i class="fa-regular fa-face-meh"></i>
                                                                <label for="survey">{{ __('Neutral') }}</label>
                                                            </div>
                                                        </div>
                                                        <div class="input-container text-center">
                                                            <input id="survey" type="radio"
                                                                name="survey-{{ $practice->practiceQuestions->id }}"
                                                                value="4"
                                                                class="{{ app()->getLocale()=='ar'?'right-input-margin':'left-input-margin' }}">
                                                            <div class="radio-tile">
                                                                <i class="fa-regular fa-face-smile"></i>
                                                                <label for="survey">{{ __('Agree') }}</label>
                                                            </div>
                                                        </div>

                                                        <div class="input-container text-center">
                                                            <input id="survey" type="radio"
                                                                name="survey-{{ $practice->practiceQuestions->id }}"
                                                                value="5"
                                                                class="{{ app()->getLocale()=='ar'?'right-input-margin':'left-input-margin' }}">
                                                            <div class="radio-tile">
                                                                <i class="fa-regular fa-face-smile-beam"></i>
                                                                <label for="survey">{{ __('Strongly Agree') }}</label>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </fieldset>
                                            @endforeach
                                            @if ($loop->last && count($open_end_q)==0)
                                            <div class="btnwxsc">
                                                <a href="javascript:void(0)"
                                                    class="btn btn-primary {{ app()->getLocale()=='ar'? 'float-start':'float-end'}} mt-5"
                                                    data-bs-submit>{{
                                                    __('Submit')
                                                    }}
                                                    <img id="loader" src="{{ asset('assets/img/loader.gif') }}" alt=""
                                                        srcset="" width="20" class="d-none">
                                                </a>
                                            </div>

                                            @else
                                            <div class="btnwxsc">
                                                <a href="javascript:void(0)"
                                                    class="btn btn-primary {{ app()->getLocale()=='ar'? 'float-start':'float-end'}} mt-5"
                                                    data-bs-next>{{
                                                    __('Next')
                                                    }}</a>
                                            </div>
                                            @endif
                                            <div class="btnwxsc">
                                                <a href="javascript:void(0)"
                                                    class="btn btn-primary {{ app()->getLocale()=='ar'? 'float-end':'float-start'}} mt-5"
                                                    data-bs-previous>{{
                                                    __('Previous')
                                                    }}</a>
                                            </div>
                                        </div>
                                        @endforeach
                                        @if (count($open_end_q)>0)
                                        <div class="my-wizard-continar">
                                            {{-- --}}
                                            @foreach ($open_end_q as $question)
                                            <div class="form-group col-lg-8 col-md-9 col-sm-12">
                                                <label for="email">
                                                    @if (app()->getLocale()=='ar')
                                                    {{ $question->question_ar}}
                                                    @elseif (app()->getLocale()=='en')
                                                    {{ $question->question}}
                                                    @else
                                                    {{ $question->question_in}}
                                                    @endif
                                                </label>
                                                <input type="text" name="oequestion_{{ $question->id }}"
                                                    id="{{ $question->id }}" class="form-control oe-question"
                                                    placeholder="" aria-describedby="helpId{{ $question->id }}"
                                                    onkeypress="checkval('{{ $question->id }}')">
                                                <small id="helpId{{ $question->id }}" class="text-muted">{{ __('max 55
                                                    letters') }}</small>
                                            </div>
                                            @endforeach
                                            <div class="btnwxsc">
                                                <a href="javascript:void(0)"
                                                    class="btn btn-primary {{ app()->getLocale()=='ar'? 'float-start':'float-end'}} mt-5"
                                                    data-bs-submit>{{
                                                    __('Submit')
                                                    }}
                                                    <img id="loader" src="{{ asset('assets/img/loader.gif') }}" alt=""
                                                        srcset="" width="20" class="d-none">
                                                </a>
                                            </div>
                                        </div>
                                        @endif
                                        {{-- personal details --}}
                                        {{-- <div class="my-wizard-continar"> --}}
                                            {{-- collect first name and second name --}}
                                            {{--
                                            <div class="form-group col-lg-6 col-md-9 col-sm-12">
                                                <label for="first_name">{{ __('First Name:') }}</label>
                                                <input type="text" name="first_name" id="" class="form-control"
                                                    placeholder="{{ __('Enter First Name') }}"
                                                    aria-describedby="helpId">
                                                <small id="helpId" class="text-muted">{{ __('First Name') }}</small>
                                            </div>
                                            <div class="form-group col-lg-6 col-md-9 col-sm-12">
                                                <label for="second_name">{{ __('Second Name:') }}</label>
                                                <input type="text" name="second_name" id="" class="form-control"
                                                    placeholder="{{ __('Enter Second Name') }}"
                                                    aria-describedby="helpId">
                                                <small id="helpId" class="text-muted">{{ __('Second Name') }}</small>
                                            </div> --}}


                                            {{-- next btn --}}
                                            {{-- a link with javascript void --}}

                                            {{-- <button type="button" class="btn btn-primary float-end" data-bs-next>{{
                                                __('Next')
                                                }}</button>
                                            <button type="button" class="btn btn-primary float-start"
                                                data-bs-previous>{{
                                                __('Previous')
                                                }}</button>
                                        </div> --}}
                                        {{-- contact details --}}
                                        {{-- <div class="my-wizard-continar"> --}}
                                            {{-- email address phone and mobile --}}
                                            {{--
                                            <div class="form-group col-lg-6 col-md-9 col-sm-12">
                                                <label for="email">{{ __('Email address:') }}</label>
                                                <input type="email" name="email" id="" class="form-control"
                                                    placeholder="{{ __('Enter Email Address') }}"
                                                    aria-describedby="helpId">
                                                <small id="helpId" class="text-muted">{{ __('Email Address') }}</small>
                                            </div>
                                            <div class="form-group col-lg-6 col-md-9 col-sm-12">
                                                <label for="phone">{{ __('Phone:') }}</label>
                                                <input type="text" name="phone" id="" class="form-control"
                                                    placeholder="{{ __('Enter Phone Number') }}"
                                                    aria-describedby="helpId">
                                                <small id="helpId" class="text-muted">{{ __('Phone Number') }}</small>
                                            </div>
                                            <div class="form-group col-lg-6 col-md-9 col-sm-12">
                                                <label for="mobile">{{ __('Mobile:') }}</label>
                                                <input type="text" name="mobile" id="" class="form-control"
                                                    placeholder="{{ __('Enter Mobile Number') }}"
                                                    aria-describedby="helpId">
                                                <small id="helpId" class="text-muted">{{ __('Mobile Number') }}</small>
                                            </div>

                                            <button type="button" class="btn btn-primary float-end" data-bs-next>{{
                                                __('Next')
                                                }}</button>
                                            <button type="button" class="btn btn-primary float-start"
                                                data-bs-previous>{{
                                                __('Previous')
                                                }}</button>
                                        </div> --}}
                                        {{-- employee details --}}
                                        {{-- <div class="my-wizard-continar">
                                            {{-- department designation role --}}

                                            {{-- <div class="form-group col-lg-6 col-md-9 col-sm-12">
                                                <label for="department">{{ __('Department:') }}</label>
                                                <input type="text" name="department" id="" class="form-control"
                                                    placeholder="{{ __('Enter Department') }}"
                                                    aria-describedby="helpId">
                                                <small id="helpId" class="text-muted">{{ __('Department') }}</small>
                                            </div>
                                            <div class="form-group col-lg-6 col-md-9 col-sm-12">
                                                <label for="designation">{{ __('Designation:') }}</label>
                                                <input type="text" name="designation" id="" class="form-control"
                                                    placeholder="{{ __('Enter Designation') }}"
                                                    aria-describedby="helpId">
                                                <small id="helpId" class="text-muted">{{ __('Designation') }}</small>
                                            </div>
                                            <div class="form-group col-lg-6 col-md-9 col-sm-12">
                                                <label for="role">{{ __('Role:') }}</label>
                                                <input type="text" name="role" id="" class="form-control"
                                                    placeholder="{{ __('Enter Role') }}" aria-describedby="helpId">
                                                <small id="helpId" class="text-muted">{{ __('Role') }}</small>
                                            </div>

                                            <button type="button" class="btn btn-primary float-end" data-bs-next>{{
                                                __('Next')
                                                }}</button>
                                            <button type="button" class="btn btn-primary float-start"
                                                data-bs-previous>{{
                                                __('Previous')
                                                }}</button>
                                        </div> --}}

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--=====================================================================================================================--}}
        <!-- Modal -->
        <div class="modal fade" id="Language" tabindex="-1" aria-labelledby="LanguageLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="LanguageLabel">{{ __('Choose Your Language') }}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex flex-row d-flex justify-content-center">
                            <div class="p-2 d-flex justify-content-center"><a href="{{ route('lang.swap','en') }}"
                                    class="btn btn-sm btn-secondary">
                                    <h5>ُEnglish</h5>
                                    <img src="{{ asset('assets/img/UKFLag.png') }}" class="img-fluid" alt=""
                                        height="100" width="100" srcset="">
                                    {{-- add cdn UK flag to the button --}}
                                </a></div>
                            <div class="p-2 d-flex justify-content-center" dir="rtl"><a
                                    href="{{ route('lang.swap','ar') }}" class="btn btn-sm btn-secondary">
                                    <h5>العربية</h5>
                                    <img src="{{ asset('assets/img/OmanFlage.png') }}" alt="" class="img-fluid"
                                        height="100" width="100" srcset="">
                                </a></div>
                            <div class="p-2 d-flex justify-content-center"><a href="{{ route('lang.swap','in') }}"
                                    class="btn btn-sm btn-secondary">
                                    <h5>हिंदी</h5>
                                    <img src="{{ asset('assets/img/IndiaFlag.png') }}" alt="" class="img-fluid"
                                        height="100" width="100" srcset="">
                                </a></div>
                        </div>
                    </div>
                    {{-- <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
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
                            <a id="logo" href="https://www.hrfactoryapp.com/"
                                class="d-inline-block margin-top-20px"><img src="{{ asset('assets/img/logo.png') }}"
                                    height="" alt=""></a>
                        </div>
                    </div>
                    <!-- // Social -->
                </div>
                <div class="col-4 col-lg-2 col-md-2 wow fadeInUp" data-wow-delay="0.2s">
                    {{-- <ul class="list-inline text-left margin-lr-0px text-white"> --}}
                        {{-- <li class="list-inline-item"><a class="twitter cms" data-contentId="105"
                                href="https://twitter.com/HRFactory4"><i class="fab fa-twitter"></i></a></li>
                        <li class="list-inline-item"><a class="youtube cms" data-contentId="106"
                                href="https://www.instagram.com/hrfactoryapp/"><i class="fab fa-instagram"></i></a>
                        </li>
                        <li class="list-inline-item"><a class="linkedin cms" data-contentId="107"
                                href="https://www.linkedin.com/company/hr-factory-app"><i
                                    class="fab fa-linkedin"></i></a></li> --}}
                        {{-- @if (!Auth::check())
                        <li class="list-inline-item"> <a href="{{ route('login') }}"
                                class="text-white text-decoration-none">
                                <i class=""></i>
                                {{ __('Login') }}
                            </a></li>
                        @endif

                    </ul> --}}
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

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        //document ready function
    $(document).ready(function () {
        if("{{ session('locale') }}" =="")
        {$('#Language').modal('show');


    }
    var submitclicked=false;
        //next button click function
        //form
    var form = document.querySelector('[data-bs-multi-step-form]');
       //get array of divs that has my-wizard-continar class
    var divs = [...form.querySelectorAll('.my-wizard-continar')];
    var progressSteps = [...form.querySelectorAll('.progress-step')];
    var oe_qeustions = [...form.querySelectorAll('.oe-question')];
    var progress = document.getElementById('progress');
    //get current setp form
    currentStep = parseInt(divs.findIndex(step =>{return step.classList.contains("active")}))
    if(currentStep<0)
    {
        currentStep=0;
        divs[currentStep].classList.add("active");
    }
    checkval=(id)=>{
        console.log(id);
        var input = document.getElementById(id);
        if(input.value.length>54)
        {
            let l3='{{ __("Did you consume all 55 letters?") }}';
            let l4='{{ __("You can not add more..") }}';
            Swal.fire(
                l3,
                l4,
                'error'
            );
            return;
        }
         if(input.value.length==55 && e.key!="Backspace")
                {
                    //disable current input
                    e.preventDefault();
                }

    }
//next button click event listener
    //get array of links that has btn class

    form.addEventListener('keypress',e=>{
        if(e.key=="Enter")
        {
            e.preventDefault();
        }

        // check if current input text length less than 150
        oe_qeustions.forEach(input=>{
            // if(input.classList.contains("oe-question"))
            // {
            //     var helpId = input.nextElementSibling;
            //     if(input.value.length>54)
            //     {
            //         let l3='{{ __("Did you consume all 55 letters?") }}';
            //         let l4='{{ __("You can not add more..") }}';
            //         Swal.fire(
            //             l3,
            //             l4,
            //             'error'
            //         );
            //         return;
            //     }
            //     if(input.value.length==55 && e.key!="Backspace")
            //     {
            //         //disable current input
            //         e.preventDefault();
            //     }
            //     x=55-(input.value.length+1);
            //     // find by id helpId
            //     helpId.innerHTML=x+" "+'{{ __("letters left") }}';

            // }
    })
    });
    form.addEventListener('click', e=>{
        var valid = true;
        let increment;
        var answers = [];

        //disabled e.target

        if(e.target.matches('[data-bs-submit]'))
        {
            if(submitclicked===false)
            {
                // ====== LOG START ======

                // ====== LOG END ======

                submitclicked=true;
            e.target.disabled = true;
            //show loader
            document.getElementById('loader').classList.remove("d-none");
            //get checked radio button of agegroup
            var agegroup = document.querySelector('input[id="agegroup"]:checked').value;
            //add agegroupradioValue to answers array

            //get checked radio button of gender
            var gender = document.querySelector('input[id="gender"]:checked').value;

            var oe_qeustions_ans=null
            //get all check radion button with id survey
            var radioButtons = [...form.querySelectorAll(`input[id="survey"]`)];
            //get check one only
            var radioCheckeds =[ ...radioButtons.filter(radio=>{return radio.checked})];
            radioCheckeds.forEach(radioChecked=>{
                //get value of checked radio
                var radioValue = radioChecked.value;
                //get name of checked radio
                var radioName = radioChecked.name;
                //get id of checked radio
                var radioId = radioChecked.id;
                //get all radio buttons with same name

                //split rdioName by -
                var radioNameArray = radioName.split("-");
                //get question id
                var questionId = radioNameArray[1];
                //add questionId and radioValue to answers array
                answers.push({question_id:questionId,answer:radioValue});

            })
            if(oe_qeustions.length==0) oe_qeustions_ans=null;
            else
            {
                //get all oe_qeustions values and names
                var oe_qeustions_ans = [...oe_qeustions.map(oe_qeustion=>{
                    return {questionId:oe_qeustion.id,answer:oe_qeustion.value}
                })]
                // console.log(oe_qeustions_ans);
            }
            var reply = [{
                "survey_id": '{{ $SurveyId }}',
                "PlanID": '{{ $plan_id }}',
                "priorities":  null,
                "oe_ans":  oe_qeustions_ans,
                "EmailId": '{{ $email_id }}',
                "answers": answers,
                "agegroup":agegroup,
                "gender":gender
            }];


                $.ajax({
                    type: "POST",
                    url: "{{ route('questionnair.saveAnswer') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "reply": reply
                    },
                    success: function(data) {
                        console.log(data);
                        if (data.msg == "success") {
                            toastr.success('Survey submitted successfully');
                            Swal.fire(
                                'Survey submitted successfully',
                                'Thank you for your time',
                                'success'
                            );
                            if(data.url=='')
                            {
                                setTimeout(function() {
                                window.location.href = "{{ url('/') }}";
                                }, 2000);
                            }
                            else
                            {
                                setTimeout(function() {
                                window.location.href = data.url;
                                }, 2000);
                            }
                        } else {
                            toastr.error('Something went wrong');
                            Swal.fire(
                                'Something went wrong',
                                'Please try again',
                                'error'
                            );
                        }
                    }
                });
            }
            else{
                // ====== LOG START ======

                // ====== LOG END ======

       e.preventDefault();
    }
        }
        if(e.target.matches('[data-bs-next]'))
        {
            increment=1;
            e.target.disabled = true;

        }
        if(e.target.matches('[data-bs-previous]'))
        {

        increment=-1;
        }
        //get all inputs in current step
        //check if all inputs are filled
        if (increment==null)  return;
        var inputs = [...divs[currentStep].querySelectorAll('input')];
        if(increment>0){
        inputs.forEach(input=>{

            //check if input has value
            //check if radio button is checked
            //check if input is valid

            if(input.checkValidity() && input.value !="" )
            {
                if(input.type=="radio")
                {
                    //add radio name to array
                    var radioName = input.name;
                    //get all radio buttons with same name
                    var radioButtons = [...form.querySelectorAll(`input[name="${radioName}"]`)];
                    //check if any radio button is checked
                    var radioChecked = radioButtons.some(radio=>{return radio.checked});
                    if(!radioChecked)
                    {
                        valid=false;
                        input.classList.add("is-invalid");

                        return
                    }
                }
                input.classList.remove("is-invalid");

            }
            else
            {

                valid=false;
                input.classList.add("is-invalid");
            }
        })
    }
        if(valid)
        {
            currentStep+=increment;
            showCurrentStep();
            upDateProgress();
            //get element by class

            document.querySelector(".progressbar").scrollIntoView();
        }
        else{
            let l1='{{ __("Did you answer all questions?") }}';
            let l2='{{ __("Please answer all questions") }}';
            Swal.fire(
                        l1,
                        l2,
                        'error'
                    );
        }
    })
    function showCurrentStep()
    {
        divs.forEach((element,index) => {
            element.classList.toggle("active",index===currentStep)
        });

    }
    function upDateProgress()
    {

                progressSteps.forEach((progressStep, idx) => {
    if (idx < currentStep + 1) {
        setTimeout(function() {
            if(idx>0 && idx< progressSteps.length){
            progressSteps[idx-1].classList.add("stpcomplete");
            progressSteps[idx-1].classList.remove("stpactive");}
    }, 100);
      progressStep.classList.add("stpactive");
      progressStep.classList.remove("stpcomplete");
    } else {
      progressStep.classList.remove("stpactive");
    }
  });
  const progressActive = document.querySelectorAll(".stpactive");

  progress.style.width =
    ((progressActive.length - 1) / (progressSteps.length - 1)) * 100 + "%";
    }
    ///submit button
    });
    </script>

</body>

</html>
