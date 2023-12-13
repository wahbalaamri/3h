{{-- extends --}}
@extends('layouts.main')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/CircularProgress.css') }}">
@endpush
{{-- content --}}
@section('content')
{{-- container --}}
<div class="container-fluid pt-5 mt-5">
    <div class="row">
        <div class="col-2">
            <!-- side bar menu -->
            @include('layouts.sidebar')
        </div>
        <div class="col-10" id="finalResult">
            <div class="card">
                {{-- header --}}
                <div class="card-header">
                    <div class="d-flex text-start">
                        <h3 class="card-title text-black">@if($type=='comp'){{
                            __('Company-wise') }} | {{ $entity }}@endif</h3>
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
                                    <div class="row d-flex justify-content-center align-items-center text-center">
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
                                                    <span class="caption h6">{{ __('Actively Disengaged') }}</span>
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
                                    <div class="row d-flex justify-content-center align-items-center text-center">
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
                                                        @endif"
                                                            style="height:{{ $ENPS_data_array['Favorable_score'] }}%">
                                                            <span>{{ $ENPS_data_array['Favorable_score'] }}%</span>
                                                        </div>
                                                    </div>
                                                    <span class="caption h6">{{ __('Promotors')}}</span>
                                                </div>
                                                <div class="col-sm-4 col-xs-12 progress-container">
                                                    <div class="custom-progress mb-3">
                                                        <div class="custom-progress-bar bg-warning @if ($ENPS_data_array['Nuetral_score']<=0)
                                                        text-danger
                                                    @endif" style="height:{{ $ENPS_data_array['Nuetral_score'] }}%">
                                                            <span>{{ $ENPS_data_array['Nuetral_score'] }}%</span>
                                                        </div>
                                                    </div>
                                                    <span class="caption h6 pt-3">{{ __('Passives') }}</span>
                                                </div>
                                                <div class="col-sm-4 col-xs-12 progress-container">
                                                    <div class="custom-progress mb-3">
                                                        <div class="custom-progress-bar bg-danger @if ($ENPS_data_array['UnFavorable_score']<=0)
                                                        text-danger
                                                    @endif"
                                                            style="height:{{ $ENPS_data_array['UnFavorable_score'] }}%">
                                                            <span>{{ $ENPS_data_array['UnFavorable_score'] }}%</span>
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
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- end of card --}}
            <div class="card mt-3">
                {{-- header --}}
                <div class="card-header">
                    <div class="d-flex text-start">
                        <h3 class="card-title text-black">{{__('Downloads') }}</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row text-start">
                        <div class="col-4 p-3 ">

                            <a href="{{ route('surveys.DownloadSurvey',[$id,$type,$type_id]) }}" class="btn btn-success mt-3" style="border-radius: 10px;
            -webkit-box-shadow: 5px 5px 20px 5px #ababab;
            box-shadow: 5px 5px 20px 5px #ababab;">{{ __('Download Survey Answers') }}</a>
                        </div>
                        <div class="col-4 p-3 ">

                            <a href="{{ route('survey-answers.resultPDF',$id) }}" class="btn btn-success mt-3" style="border-radius: 10px;
            -webkit-box-shadow: 5px 5px 20px 5px #ababab;
            box-shadow: 5px 5px 20px 5px #ababab;">{{ __('Download Survey Result PDF') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
{{-- scripts --}}
