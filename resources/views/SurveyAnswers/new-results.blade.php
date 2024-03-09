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
                            __('Company-wise') }} | {{ $entity }}
                            @elseif ($type=='sec')
                            {{__('Sector-wise') }} | {{ $entity }}
                            @else
                            {{__('Organizational-wise') }} | {{ $entity }}
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
                                    <div class="row d-flex justify-content-center align-items-center text-center">
                                        <div class="col-12">
                                            <div class="speedometer
                                        @if ($outcomes[0]['outcome_index']>=75)
                                        speed-5
                                        @elseif($outcomes[0]['outcome_index']>=60)
                                        speed-4
                                        @elseif($outcomes[0]['outcome_index']>=50)
                                        speed-3
                                        @elseif($outcomes[0]['outcome_index']>=40)
                                        speed-2
                                        @else
                                        speed-1
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
                                                @endif" style="height:{{ $outcomes[0]['Favorable_score'] }}%; min-height: 15% !important;">
                                                            <span>{{ $outcomes[0]['Favorable_score'] }}%</span>
                                                        </div>
                                                    </div>
                                                    <span class="caption h6">{{ __('Engaged') }}</span>
                                                </div>
                                                <div class="col-sm-4 col-xs-12 progress-container">
                                                    <div class="custom-progress mb-3">
                                                        <div class="custom-progress-bar bg-warning @if ($outcomes[0]['Nuetral_score']<=0) text-danger @endif"
                                                            style="height:{{ $outcomes[0]['Nuetral_score'] }}%; min-height: 15% !important;">
                                                            <span>{{ $outcomes[0]['Nuetral_score'] }}%</span>
                                                        </div>
                                                    </div>
                                                    <span class="caption h6">{{ __('Nuetral') }}</span>
                                                </div>
                                                <div class="col-sm-4 col-xs-12 progress-container">
                                                    <div class="custom-progress mb-3">
                                                        <div class="custom-progress-bar bg-danger @if ($outcomes[0]['UnFavorable_score']<=0)
                                                    text-danger
                                                @endif" style="height:{{ $outcomes[0]['UnFavorable_score'] }}%; min-height: 15% !important;">
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
                                            @if ( $ENPS_data_array['ENPS_index']>0)
                                        speed-5
                                        @elseif( $ENPS_data_array['ENPS_index']==0)
                                        speed-3
                                        @elseif( $ENPS_data_array['ENPS_index']<0)
                                        speed-1
                                        {{-- @elseif( $ENPS_data_array['ENPS_index']>=40)
                                        speed-2 --}}
                                        @else
                                        speed-1
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
                                                            style="height:{{ $ENPS_data_array['Favorable_score'] }}%; min-height: 15% !important;">
                                                            <span>{{ $ENPS_data_array['Favorable_score'] }}%</span>
                                                        </div>
                                                    </div>
                                                    <span class="caption h6">{{ __('Promotors')}}</span>
                                                </div>
                                                <div class="col-sm-4 col-xs-12 progress-container">
                                                    <div class="custom-progress mb-3">
                                                        <div class="custom-progress-bar bg-warning @if ($ENPS_data_array['Nuetral_score']<=0)
                                                        text-danger
                                                    @endif"
                                                            style="height:{{ $ENPS_data_array['Nuetral_score'] }}%; min-height: 15% !important;">
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
                                                            style="height:{{ $ENPS_data_array['UnFavorable_score'] }}%; min-height: 15% !important;">
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

                                        @if ($function['Favorable_score']>=75)
                                        speed-5
                                        @elseif($function['Favorable_score']>=60)
                                        speed-4
                                        @elseif($function['Favorable_score']>=50)
                                        speed-3
                                        @elseif($function['Favorable_score']>=40)
                                        speed-2
                                        @else
                                        speed-1
                                        @endif
                                        ">
                                            <div class="pointer"></div>
                                        </div>
                                        <h3 class="caption">{{ $function['Favorable_score'] }}%</h3>
                                        @foreach ($drivers as $practice)
                                        @if ($practice['function']==$function['function'])

                                        <div class="col-12 pt-2 pb-2 text-center mb-2 rounded
                                            @if ($practice['Favorable_score']>=75)
                                            bg-success text-white
                                            @elseif($practice['Favorable_score']>=40)
                                                bg-warning
                                                @else
                                                bg-danger text-white
                                            @endif
                                            ">
                                            {{ $practice['practice_title'] }}{{-- -- {{ $practice['Favorable_score']}}
                                            --}}
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
            {{-- card for Top and Bottom Scores-Organizational Wide --}}
            <div class="card shadow p-3 mb-5 bg-white rounded">
                {{-- header --}}
                <div class="card-header d-flex align-items-center">
                    <h2 class="h4 text-orange">{{ __('Top and Bottom Scores - ')}}@if ($type=='comp')
                        {{ __('Company-Wise') }}
                        @elseif ($type=='sec')
                        {{ __('Sector-Wise') }}
                        @else
                        {{ __('Corporation-Wise') }}
                        @endif
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
                                        @foreach ($driver_practice_desc as $parctice)

                                        @if ($parctice['Favorable_score']>=75)
                                        <span class="caption"> {{ $parctice['practice_title']
                                            }}</span>
                                        <div class="progress" role="progressbar" aria-label="Warning example"
                                            aria-valuenow="{{  $parctice['Favorable_score'] }}" aria-valuemin="0"
                                            aria-valuemax="100" style="height: 20px; padding: 0;">
                                            <div class="progress-bar text-bg-success"
                                                style="width: {{  $parctice['Favorable_score'] }}% ; font-size: 0.9rem;">
                                                {{
                                                $parctice['Favorable_score'] }}%</div>
                                        </div>
                                        @endif
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
                                        <div class="progress-bar bg-success" style="width: 25%"></div>
                                        @foreach ($driver_practice_asc as $parctice)
                                        @if ($parctice['Favorable_score']<75) <span class="caption"> {{
                                            $parctice['practice_title']
                                            }}</span>
                                            <div class="progress" role="progressbar" aria-label="Warning example"
                                                aria-valuenow="{{  $parctice['Favorable_score'] }}" aria-valuemin="0"
                                                aria-valuemax="100" style="height: 20px; padding: 0;">
                                                <div class="progress-bar
                                    @if ($parctice['Favorable_score']>=75)
                                    text-bg-success
                                    @elseif ($parctice['Favorable_score']>=40)
                                    text-bg-warning
                                    @else
                                    text-bg-danger
                                    @endif
                                    " style="width: {{  $parctice['Favorable_score'] }}% ; font-size: 0.9rem;">
                                                    {{
                                                    $parctice['Favorable_score'] }}%</div>
                                            </div>
                                            @endif
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
            @if($type!='comp')
            <div class="card shadow p-3 mb-5 bg-white rounded">
                {{-- header --}}
                <div class="card-header d-flex align-items-center">
                    <h2 class="h4 text-orange">{{ __('Heat Map - Engagement Drivers Result across ') }}</h2>
                </div>
                {{-- body --}}
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-active table-bordered" aria-colspan="2" style="font-size: 1.15rem;">
                            <thead>
                                <tr class="text-center">
                                    <th class="bg-info text-white">@if ($type=='all')
                                        {{ __('Sector') }}
                                        @elseif ($type=='sec')
                                        {{ __('Sector') }}
                                        @endif</th>
                                    <th class="bg-info text-white">{{ __('Engagement Index') }}</th>
                                    <th class="bg-info text-white">{{ __('Head') }}</th>
                                    <th class="bg-info text-white">
                                        {{ __('Hand') }}
                                    </th>
                                    <th class="bg-info text-white">{{ __('Heart') }}</th>
                                    <th class="bg-info text-white">{{ __('eNPS') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($heat_map as $heat)

                                <tr class="text-center" onclick="@if ($type=='comp')
                                        '#'
                                    @else
                                    @if ($cal_type=='sum')
                                    window.open('{{ route('survey-answers.alzubair_result',[$id,$type=='all'?'sec':'comp',$heat['entity_id']]) }}','_blank');
                                    @elseif($cal_type=='countD')
                                    window.open('{{ route('survey-answers.result',[$id,$type=='all'?'sec':'comp',$heat['entity_id']]) }}','_blank');
                                    @else
                                    window.open('{{ route('survey-answers.alzubair_resultC',[$id,$type=='all'?'sec':'comp',$heat['entity_id']]) }}','_blank');
                                    @endif
                                    @endif">
                                    <a href="#">
                                        <td class="bg-light">{{ $heat['entity_name'] }}</td>

                                        <td class="@if ($heat['indecators'][3]['score']>=75)
                                        bg-success
                                    @elseif($heat['indecators'][3]['score']>=40)
                                        bg-warning
                                        @else
                                        bg-danger
                                    @endif text-white">
                                            {{ $heat['indecators'][3]['score'] }}
                                        </td>
                                        <td class="@if ($heat['indecators'][0]['score']>=75)
                                        bg-success
                                    @elseif($heat['indecators'][0]['score']>=40)
                                        bg-warning
                                        @else
                                        bg-danger
                                    @endif text-white">
                                            {{ $heat['indecators'][0]['score'] }}
                                        </td>
                                        <td class="@if ($heat['indecators'][1]['score']>=75)
                                        bg-success
                                    @elseif($heat['indecators'][1]['score']>=40)
                                        bg-warning
                                        @else
                                        bg-danger
                                    @endif text-white">
                                            {{ $heat['indecators'][1]['score'] }}
                                        </td>
                                        <td class="@if ($heat['indecators'][2]['score']>=75)
                                        bg-success
                                    @elseif($heat['indecators'][2]['score']>=40)
                                        bg-warning
                                        @else
                                        bg-danger
                                    @endif text-white">
                                            {{ $heat['indecators'][2]['score'] }}
                                        </td>
                                        <td class="@if ($heat['indecators'][4]['score']>0)
                                        bg-success
                                    @elseif($heat['indecators'][4]['score']==0)
                                        bg-warning
                                        @else
                                        bg-danger
                                    @endif text-white">
                                            {{ $heat['indecators'][4]['score'] }}
                                        </td>

                                </tr>

                                @endforeach
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
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

                            <a href="{{ route('surveys.DownloadSurvey',[$id,$type,$type_id]) }}"
                                class="btn btn-success mt-3" style="border-radius: 10px;
            -webkit-box-shadow: 5px 5px 20px 5px #ababab;
            box-shadow: 5px 5px 20px 5px #ababab;">{{ __('Download Survey Answers') }}</a>
                        </div>
                        <div class="col-4 p-3 ">

                            <a href="{{ route('survey-answers.resultPDF',[$id,$type,$type_id]) }}"
                                class="btn btn-success mt-3" style="border-radius: 10px;
            -webkit-box-shadow: 5px 5px 20px 5px #ababab;
            box-shadow: 5px 5px 20px 5px #ababab;">{{ __('Download Survey Result PDF') }}</a>
                        </div>
                        <div class="col-4 p-3 ">
                            {{-- <button id="printButton" class="btn btn-success mt-3" style="border-radius: 10px;
            -webkit-box-shadow: 5px 5px 20px 5px #ababab;
            box-shadow: 5px 5px 20px 5px #ababab;">{{ __('Download Survey Result PDF') }}</button>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
{{-- scripts --}}
@section('scripts')
<script>
    document.getElementById('printButton').addEventListener('click', function() {
            window.print();
        });
</script>
@endsection
