{{-- extends --}}
@extends('layouts.main')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/CircularProgress.css') }}">
@endpush
{{-- content --}}
@section('content')
{{-- container --}}
<div class="container-fluid pt-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-10" id="finalResult">
            {{-- start function --}}
            <div id="Function" class="card">
                <div class="card-header">
                    <h3 class="card-title">Results</h3>
                </div>
                <div class="card-body text-capitalize" style="font-family: emoji;letter-spacing: 2px;">

                    <div class="col-{{ count($functions) }} text-start h3 text-white p-3" style="background-color: #376092;border-radius: 45px 45px 45px 45px;width: 89%; -webkit-box-shadow: 5px 5px 20px 5px #ABABAB;
                        box-shadow: 5px 5px 20px 5px #ABABAB;">Key functions
                    </div>
                    <div class="row  padding-left-10px">
                        @foreach ($functions as $function )
                        <div class="text-center text-white m-1" style="background-color: #376092; width:10.5%; border-radius: 10px; -webkit-box-shadow: 5px 5px 20px 5px #ABABAB;
                        box-shadow: 5px 5px 20px 5px #ABABAB;">
                            {{ $function->FunctionTitle }}
                        </div>
                        @endforeach
                    </div>
                    <div class="row" style="width: 100%">
                        @foreach ($functions as $function )
                        <?php $firstofFirstLoop= $loop->first ; ?>
                        <div class="col-1 m-1 justify-content-center" style="width: 10.5%;">
                            @foreach( $overall_Practices as $overall_Practice)
                            @if ( $overall_Practice['function_id'] == $function->id)
                            <div class="text-center @if(!$loop->first) mt-1 @endif @if($firstofFirstLoop) pl-1 pr-1 pb-1 @else p-2 m-1 @endif @if($overall_Practice['weight']<=0.6) bg-danger text-white @elseif (($overall_Practice['weight']>0.6)&&($overall_Practice['weight']<=0.8)) bg-warning text-black @else bg-success text-white @endif"
                                style=" width:125%; border-radius: 10px; -webkit-box-shadow: 5px 5px 20px 5px #ABABAB;
                                box-shadow: 5px 5px 20px 5px #ABABAB;">
                                {{ $overall_Practice['name'] }}
                            </div>
                            @endif
                            @endforeach
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            {{-- end function --}}
            {{-- start dasboard --}}
            <div id="key" class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">Key improvement areas </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-3 m-1 rounded text-center h3 p-3"
                            style="background-color: #DCE6F2 ; color:#376092 !important;">Overall Performance
                            <div class="mt-5">
                                <div class="circle-wrap">
                                    <div class="circle">

                                        <div class="mask half">
                                            <div class="fill-{{ $overallResult }}"></div>
                                        </div>

                                        <div class="mask full-{{ $overallResult }}">
                                            <div class="fill-{{ $overallResult }}"></div>
                                        </div>
                                        <div class="inside-circle"> {{ $overallResult }}%<p>Performance score</p>
                                        </div>


                                    </div>
                                </div>
                                <div class="pt-3">
                                    Overall performance of HR functionality,
                                </div>
                            </div>
                        </div>
                        <div class="col-4 m-1 rounded text-center h3 p-3"
                            style="background-color: #DCE6F2 ; color:#376092 !important;">Key improvement areas

                            @for ($i=0; $i<5; $i++) <div class="mt-5 text-start">
                                <span class="h5"> {{ $asc_perform[$i]['function'] }}</span>

                                <div class="progress" style="height: 31px">
                                    <div class="progress-bar
                                    @if($asc_perform[$i]['performance']<=60) bg-danger @elseif($asc_perform[$i]['performance']>60 && $asc_perform[$i]['performance']<80) bg-warning @else bg-success @endif"
                                        role="progressbar"
                                        style="width: {{ $asc_perform[$i]['performance']  }}%; font-size: 1rem"
                                        aria-valuenow="{{ $asc_perform[$i]['performance']  }}" aria-valuemin="0"
                                        aria-valuemax="100">{{ $asc_perform[$i]['performance'] }}%
                                    </div>
                                </div>
                        </div>

                        @endfor

                    </div>
                    <div class="col-4 m-1 rounded text-center h3 p-3"
                        style="background-color: #DCE6F2 ; color:#376092 !important;">Strength Areas
                        @for($i=(count($asc_perform)-1); $i>=(count($asc_perform)-3); $i--) <div
                            class="mt-5 text-start">
                            <span class="h5"> {{ $asc_perform[$i]['function'] }}</span>
                            <div class="progress" style="height: 31px">
                                <div class="progress-bar @if($asc_perform[$i]['performance']<=60) bg-danger @elseif($asc_perform[$i]['performance']>60 && $asc_perform[$i]['performance']<80) bg-warning @else bg-success @endif"
                                    role="progressbar"
                                    style="width: {{ $asc_perform[$i]['performance']  }}%; font-size: 1rem"
                                    aria-valuenow="{{ $asc_perform[$i]['performance']  }}" aria-valuemin="0"
                                    aria-valuemax="100">{{ $asc_perform[$i]['performance'] }}%</div>
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>
            </div>
            {{-- end dashboard --}}
            {{-- start HR View --}}
            <div id="HRaverages" class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title ">Averages by functions
                    </h3>
                </div>
                <div class="card-body" style="background-color: #DCE6F2 ; color:#376092 !important;">
                    <div class="row text-center">
                        <div class="m-1 rounded text-center h5 p-3">
                            People management performance – HR Team view Average scores by people functions
                        </div>
                    </div>
                    <div class="row">
                        @foreach ($sorted_hr_performences as $performence)


                        <div class="col-3 text-end function-lable">{{ $performence['function'] }}</div>
                        <div class="col-9 text-start function-progress">
                            <div class="progress" style="height: 31px">
                                <div class="progress-bar @if($performence['performance']>80 && $performence['performance']<=100) bg-success @elseif($performence['performance']>60 && $performence['performance']<=80) bg-warning @else bg-danger @endif"
                                    role="progressbar" style="width: {{ $performence['performance'] }}%; font-size: 1rem"
                                    aria-valuenow="{{ $performence['performance'] }}" aria-valuemin="0" aria-valuemax="100">
                                    {{
                                    $performence['performance'] }}%</div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
            {{-- end HR view --}}

        </div>
    </div>
</div>
{{-- end container --}}
@endsection
{{-- end content --}}
