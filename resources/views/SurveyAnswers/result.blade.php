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
            <div id="Function" class="card" style="font-family: emoji;letter-spacing: 0.065rem;">
                <div class="card-header">
                    <h3 class="card-title">Results</h3>
                </div>
                <div class="card-body text-capitalize">

                    <div class="col-{{ count($functions) }} text-start h3 text-white p-3" style="background-color: #376092;border-radius: 45px 45px 45px 45px;width: 89%; -webkit-box-shadow: 5px 5px 20px 5px #ABABAB;
                        box-shadow: 5px 5px 20px 5px #ABABAB;">Key functions
                    </div>
                    <div class="row  padding-left-10px">
                        @foreach ($functions as $function )
                        <div class="text-center text-white m-1" style="background-color: #376092; width:10.5%; border-radius: 10px; -webkit-box-shadow: 5px 5px 20px 5px #ABABAB;
                        box-shadow: 5px 5px 20px 5px #ABABAB; font-size: 0.79rem">
                            {{ $function->FunctionTitle }}
                        </div>
                        @endforeach
                    </div>
                    <div class="row" style="width: 100%">
                        @foreach ($functions as $function )
                        <?php $firstofFirstLoop= $loop->first ; ?>
                        <div class="col-1 m-1 justify-content-center" style="width: 10.5%; font-size: 0.79rem">
                            @foreach( $overall_Practices as $overall_Practice)
                            @if ( $overall_Practice['function_id'] == $function->id)
                            <div class="text-center @if(!$loop->first) mt-1 @endif @if($firstofFirstLoop) pl-1 pr-1 pb-1 @else p-2 m-1 @endif @if($overall_Practice['weight']<=0.6) bg-danger text-white @elseif (($overall_Practice['weight']>0.6)&&($overall_Practice['weight']<=0.8)) bg-warning text-black @else bg-success text-white @endif"
                                style=" width:125%; border-radius: 10px; -webkit-box-shadow: 5px 5px 20px 5px #ABABAB;
                                box-shadow: 5px 5px 20px 5px #ABABAB;">
                                {{ $overall_Practice['name'] }} {{-- {{ $overall_Practice['weight'] }} --}}
                            </div>
                            @endif
                            @endforeach
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <button id="FunctionDownload" onclick="downloadResult('Function','Function')"
                class="btn btn-success mt-1">Download Function</button>
            <div id="key" class="card mt-4" style="font-family: emoji;letter-spacing: 0.065rem;">
                <div class="card-header">
                    <h3 class="card-title">Dashboard</h3>
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
                            @if($asc_perform[$i]['performance'] >80)
                            <span class="h5"> {{ $asc_perform[$i]['function'] }}</span>
                            <div class="progress" style="height: 31px">
                                <div class="progress-bar @if($asc_perform[$i]['performance']<=60) bg-danger @elseif($asc_perform[$i]['performance']>60 && $asc_perform[$i]['performance']<80) bg-warning @else bg-success @endif"
                                    role="progressbar"
                                    style="width: {{ $asc_perform[$i]['performance']  }}%; font-size: 1rem"
                                    aria-valuenow="{{ $asc_perform[$i]['performance']  }}" aria-valuemin="0"
                                    aria-valuemax="100">{{ $asc_perform[$i]['performance'] }}%</div>
                            </div>
                            @endif
                        </div>
                        @endfor
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <span class="legend-result"><b>Legend:</b></span> <span class="legend-levels"><b> Low:</b></span>
                <=60% – <span class="legend-levels"><b>Medium:</b></span> > 60% to 80% – <span
                        class="legend-levels"><b>High:</b></span> >80%

            </div>
        </div>
        <button id="keyDownload" onclick="downloadResult('key','Dashboard')" class="btn btn-success mt-1">Download
            key</button>
        <div id="Laverages" class="card mt-4" style="font-family: emoji;letter-spacing: 0.065rem;">
            <div class="card-header">
                <h3 class="card-title ">Averages by functions - Leadership
                </h3>
            </div>
            <div class="card-body" style="background-color: #DCE6F2 ; color:#376092 !important;">
                <div class="row text-center">
                    <div class="m-1 rounded text-center h5 p-3" style="font-size: 1.7rem">
                        People management performance – <b style="font-size: 1.5rem">Leadership</b> view average scores
                        by people functions
                    </div>
                </div>
                <div class="row">
                    @foreach ($sorted_leader_performences as $performence)


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
        <button id="averagesDownload" onclick="downloadResult('Laverages','Leadership_View_Average')"
            class="btn btn-success mt-1">Download averages</button>
        <div id="HRaverages" class="card mt-4" style="font-family: emoji;letter-spacing: 0.065rem;">
            <div class="card-header">
                <h3 class="card-title ">Averages by functions - HR Team
                </h3>
            </div>
            <div class="card-body" style="background-color: #DCE6F2 ; color:#376092 !important;">
                <div class="row text-center">
                    <div class="m-1 rounded text-center h5 p-3" style="font-size: 1.7rem">
                        People management performance – <b style="font-size: 1.5rem">HR Team</b> view Average scores by
                        people functions
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
                    {{-- <div class="col-3 text-end function-lable">Function 6</div>
                    <div class="col-9 text-start function-progress">
                        <div class="progress" style="height: 31px">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 95%; font-size: 1rem"
                                aria-valuenow="95" aria-valuemin="0" aria-valuemax="100">95%</div>
                        </div>
                    </div>
                    <div class="col-3 text-end function-lable">Function 8</div>
                    <div class="col-9 text-start function-progress">
                        <div class="progress" style="height: 31px">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 81%; font-size: 1rem"
                                aria-valuenow="81" aria-valuemin="0" aria-valuemax="100">81%</div>
                        </div>
                    </div>
                    <div class="col-3 text-end function-lable">Function 5</div>
                    <div class="col-9 text-start function-progress">
                        <div class="progress" style="height: 31px">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 80%; font-size: 1rem"
                                aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">80%</div>
                        </div>
                    </div>
                    <div class="col-3 text-end function-lable">Function 4</div>
                    <div class="col-9 text-start function-progress">
                        <div class="progress" style="height: 31px">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 79%; font-size: 1rem"
                                aria-valuenow="79" aria-valuemin="0" aria-valuemax="100">79%</div>
                        </div>
                    </div>
                    <div class="col-3 text-end function-lable">Function 7</div>
                    <div class="col-9 text-start function-progress">
                        <div class="progress" style="height: 31px">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 78%; font-size: 1rem"
                                aria-valuenow="78" aria-valuemin="0" aria-valuemax="100">78%</div>
                        </div>
                    </div>
                    <div class="col-3 text-end function-lable">Function 3</div>
                    <div class="col-9 text-start function-progress">
                        <div class="progress" style="height: 31px">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 67%; font-size: 1rem"
                                aria-valuenow="67" aria-valuemin="0" aria-valuemax="100">67%</div>
                        </div>
                    </div>
                    <div class="col-3 text-end function-lable">Function 2</div>
                    <div class="col-9 text-start function-progress">
                        <div class="progress" style="height: 31px">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 59%; font-size: 1rem"
                                aria-valuenow="59" aria-valuemin="0" aria-valuemax="100">59%</div>
                        </div>
                    </div>
                    <div class="col-3 text-end function-lable">Function 1</div>
                    <div class="col-9 text-start function-progress">
                        <div class="progress" style="height: 31px">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 34%; font-size: 1rem"
                                aria-valuenow="34" aria-valuemin="0" aria-valuemax="100">34%</div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
        <button id="averagesDownload" class="btn btn-success mt-1"
            onclick="downloadResult('HRaverages','HR_View_Average')">Download averages</button>
        <div id="Empaverages" class="card mt-4" style="font-family: emoji;letter-spacing: 0.065rem;">
            <div class="card-header">
                <h3 class="card-title ">Averages by functions - Employees
                </h3>
            </div>
            <div class="card-body" style="background-color: #DCE6F2 ; color:#376092 !important;">
                <div class="row text-center">
                    <div class="m-1 rounded text-center h5 p-3" style="font-size: 1.7rem">
                        People management performance – <b style="font-size: 1.5rem">Employee</b> view Average scores by
                        people functions
                    </div>
                </div>
                <div class="row">
                    @foreach ($sorted_emp_performences as $performence)


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
        <button id="averagesDownload" class="btn btn-success mt-1"
            onclick="downloadResult('Empaverages','Employee_View_Average')">Download averages</button>

        <div id="heatmap" class="card mt-4" style="font-family: emoji;letter-spacing: 0.065rem;">
            <div class="card-header">
                <h3 class="card-title ">High level heat map
                </h3>
            </div>
            <div class="card-body" style="background-color: #DCE6F2 ; color:#376092 !important;">
                <div class="row text-center">
                    <div class="m-1 rounded text-center h5 p-3 text-danger" style="font-size: 1.7rem">
                        High level heat map – Leadership view Priorities vs Performance in key People management
                        functions
                    </div>
                </div>
                <div class="row">
                    <div class="col-3 text-center heat-map heat-map-priority heat-map-priority-v">Priority by
                        leaders</div>
                    <div class="col-9 heat-map"></div>

                    @for ($i = 0; $i < 3; $i++) <div
                        class="col-3 text-end heat-map heat-map-priority heat-map-priority-lable text-capitalize">
                        <span>
                            @switch($i)
                            @case(0)
                            High
                            @break

                            @case(1)
                            Medium
                            @break

                            @case(2)
                            Low
                            @break

                            @default
                            @endswitch
                        </span>
                </div>
                <div class="col-9 heat-map">
                    <div class="row">
                        @for ($j = 0; $j < 3; $j++) {{-- Start first --}} @if (($i==0 && $j==0) || ($i==0 && $j==1) ||
                            ($i==1 && $j==0)) <div class="bg-danger heat-map-result">
                            @if ($i == 0)
                            @if ($j == 0)
                            <ul>
                                @foreach ($priorities as $pri)
                                @if ($pri['priority'] >= 0.8 && $pri['priority'] <= 1) @if ($pri['performance'] <=0.6)
                                    <li class="text-white">{{ $pri['function'] }}
                                    </li>
                                    @endif
                                    @endif
                                    @endforeach
                            </ul>
                            @elseif ($j == 1)
                            <ul>

                                @foreach ($priorities as $pri)
                                @if ($pri['priority'] >= 0.8 && $pri['priority'] <= 1) @if ($pri['performance']> 0.6
                                    && $pri['performance'] <= 0.8) <li class="text-white">{{ $pri['function'] }}
                                        </li>
                                        @endif
                                        @endif
                                        @endforeach
                            </ul>

                            @else
                            <ul>

                                @foreach ($priorities as $pri)
                                ffff
                                @if ($pri['priority'] >0.6 && $pri['priority'] <0.8) @if ($pri['performance'] <=0.6) <li
                                    class="text-white">{{ $pri['function'] }}</li>
                                    @endif
                                    @endif
                                    @endforeach
                            </ul>
                            @endif
                            @else
                            @if ($j == 0)
                            <ul>

                                @foreach ($priorities as $pri)
                                @if ($pri['priority'] >0.6 && $pri['priority'] <0.8) @if ($pri['performance'] <=0.6) <li
                                    class="text-white">{{ $pri['function'] }}</li>
                                    @endif
                                    @endif
                                    @endforeach
                            </ul>
                            @endif
                            @endif
                    </div>
                    @endif
                    {{-- End first --}}
                    {{-- Start second --}}
                    @if (($i == 1 && $j == 1) || ($i == 2 && $j == 1) || ($i == 2 && $j == 0))
                    <div class="bg-warning heat-map-result">
                        @if ($i == 1)
                        @if ($j == 1)
                        <ul>

                            @foreach ($priorities as $pri)
                            @if ($pri['priority'] >0.6 && $pri['priority'] <0.8) @if ($pri['performance']> 0.6 &&
                                $pri['performance'] <= 0.8) <li class="text-black">{{ $pri['function'] }}</li>
                                    @endif
                                    @endif
                                    @endforeach
                        </ul>
                        @endif
                        @else
                        @if ($j == 0)
                        <ul>

                            @foreach ($priorities as $pri)
                            @if ($pri['priority'] <=0.6) @if ($pri['performance'] <=0.6) <li class="text-black">
                                {{$pri['function'] }}</li>
                                @endif
                                @endif
                                @endforeach
                        </ul>
                        @endif
                        @if ($j == 1)
                        <ul>

                            @foreach ($priorities as $pri)
                            @if ($pri['priority'] <=0.6) @if ($pri['performance']> 0.6 && $pri['performance'] <= 0.8)
                                    <li class="text-black">{{ $pri['function'] }}</li>
                                    @endif
                                    @endif
                                    @endforeach
                        </ul>
                        @endif
                        @endif
                    </div>
                    @endif
                    {{-- End second --}}
                    {{-- Start third --}}
                    @if (($i == 0 && $j == 2) || ($i == 1 && $j == 2) || ($i == 2 && $j == 2))
                    <div class="bg-success heat-map-result">
                        @if ($i == 0)
                        @if ($j == 2)
                        <ul>

                            @foreach ($priorities as $pri)
                            @if ($pri['priority'] >0.8 && $pri['priority'] <= 1) @if ($pri['performance']> 0.8)
                                <li class="text-white">{{ $pri['function'] }}</li>
                                @endif
                                @endif
                                @endforeach
                        </ul>
                        @endif
                        @endif
                        @if ($i == 1)
                        @if ($j == 2)
                        <ul>

                            @foreach ($priorities as $pri)
                            @if ($pri['priority'] >0.6 && $pri['priority'] < 0.8) @if ($pri['performance']> 0.8)
                                <li class="text-white">{{ $pri['function'] }}
                                </li>
                                @endif
                                @endif
                                @endforeach
                        </ul>
                        @endif
                        @endif
                        @if ($i == 2)
                        @if ($j == 2)
                        <ul>

                            @foreach ($priorities as $pri)
                            @if ($pri['priority'] <=0.6) @if ($pri['performance']> 0.8)
                                <li class="text-white">{{ $pri['function'] }}
                                </li>
                                @endif
                                @endif
                                @endforeach
                        </ul>
                        @endif
                        @endif
                    </div>
                    @endif
                    @endfor
                </div>
            </div>
            @endfor

            <div class="col-3 text-end heat-map">
                <span></span>
            </div>
            <div class="col-9 heat-map">
                <div class="row">
                    <div class="heat-map-bottom-label">Low</div>
                    <div class="heat-map-bottom-label">Medium</div>
                    <div class="heat-map-bottom-label">High</div>
                </div>
            </div>
            <div class="col-3 text-end heat-map">
                <span></span>
            </div>
            <div class="col-9 heat-map text-center p-3">
                <div class="heat-map-bottom-title">
                    People management performance score by leaders
                </div>
            </div>
        </div>
    </div>
    {{-- card footer --}}
    <div class="card-footer">
        <span class="legend-result"><b>Legend:</b></span> <span class="legend-levels"><b> Low:</b></span>
        <=60% – <span class="legend-levels"><b>Medium:</b></span> > 60% to 80% – <span
                class="legend-levels"><b>High:</b></span> >80%

    </div>
</div>
<button id="heatmapDownload" class="btn btn-success mt-1" onclick="downloadResult('heatmap','heatmap')">
    Download heatmap
</button>
<div class="card mt-4" id="Linear" style="font-family: emoji;letter-spacing: 0.065rem;">
    <div class="card-header">
        <h4 class="card-title">Linear chart</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="chart-container">
                    <canvas id="myChart" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
    </div>
    {{-- <div id="img-out"></div> --}}
    {{-- <button id="pptDownload" class="btn btn-success">Download PPT</button> --}}
</div>
<button id="heatmapDownload" class="btn btn-success mt-1" onclick="downloadResult('Linear','Linear')">Download
    Chart</button>
<div class="card mt-4" id="Consolidated" style="font-family: emoji;letter-spacing: 0.065rem;">
    <div class="card-header">
        <h4 class="card-title">Consolidated</h4>
    </div>
    <div class="card-body" style="font-family: emoji;letter-spacing: 0.065rem;">
        <div class="row">
            <div class="col-12">
                Consolidated findings by function
            </div>
        </div>
        <div class="row">
            <div class="col-sm-1 m-1 text-white" style="font-size: 0.84rem;
    border: 4px solid #376092;
    background-color: #376092;
    border-radius: 10px;
    display: flex;
    justify-content: center;
    align-content: center;
    flex-direction: column;
    text-align: center;">
                <span>Functions</span>
            </div>
            @foreach ($asc_perform as $perfomr)
            <div class="m-1 text-white" style="width: 10.4% !important; font-size: 0.8rem; border: 4px solid #376092;
    background-color: #376092;
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-content: center;
            flex-direction: column;
            text-align: center;">
                {{ $perfomr['function'] }}
            </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-sm-1 m-1 text-white" style="font-size: 0.84rem;
    border: 4px solid #376092;
    background-color: #376092;
    border-radius: 10px;
    display: flex;
    justify-content: center;
    align-content: center;
    flex-direction: column;
    text-align: center;">
                <span style="hyphens: auto;">Improvement need
                </span>
            </div>
            @foreach ($asc_perform as $perfomr)
            <div class="m-1 @if($perfomr['performance']<=60) bg-danger text-white @elseif($perfomr['performance']>80) bg-success text-white @else bg-warning @endif"
                style="width: 10.4% !important; font-size: 0.8rem border-radius: 10px;
                ">
                @if($perfomr['performance']<=60) Critical to improve @elseif($perfomr['performance']>80) No Improvement
                    Needed
                    @else Need to improve
                    @endif
            </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-sm-1 m-1 text-white" style="font-size: 0.84rem;
            border: 4px solid #376092;
            background-color: #376092;
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-content: center;
            flex-direction: column;
            text-align: center;">
                <span>Performance rating by
                    Leaders, Employees and HR Team
                </span>
            </div>
            @foreach ($asc_perform as $perfomr)

            <div class="m-1 " style="width: 10.4% !important; font-size: 0.8rem border-radius: 10px;">
                @foreach( $sorted_leader_performences as $leader)
                @if($leader['function_id'] == $perfomr['function_id'])
                <div class="row mt-2">
                    <div class="col-md-5">
                        <img src="{{ asset('assets/img/icon/LeadersIcon.png') }}" height="30" width="35" alt="">
                    </div>
                    {{ $leader['performance'] }}% <br>
                </div>
                @break;
                @endif
                @endforeach
                {{-- hr --}}
                @foreach ($sorted_hr_performences as $hr)
                @if($hr['function_id'] == $perfomr['function_id'])
                <div class="row mt-2">
                    <div class="col-md-5">
                        <img src="{{ asset('assets/img/icon/HRIcon.png') }}" height="30" width="35" alt="">
                    </div>
                    {{ $hr['performance'] }}% <br>
                </div>
                @break;
                @endif
                @endforeach
                {{-- emp --}}
                @foreach ($sorted_emp_performences as $emp)
                @if($emp['function_id'] == $perfomr['function_id'])
                <div class="row mt-2">
                    <div class="col-md-5">
                        <img src="{{ asset('assets/img/icon/EmployeIcon.png') }}" height="30" width="35" alt="">
                    </div>
                    {{ $emp['performance'] }}% <br>
                </div>
                @break;
                @endif
                @endforeach
            </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-sm-1 m-1 text-white" style="font-size: 0.84rem;
    border: 4px solid #376092;
    background-color: #376092;
    border-radius: 10px;
    display: flex;
    justify-content: center;
    align-content: center;
    flex-direction: column;
    text-align: center;">
                <span>Priority
                </span>
            </div>
            @foreach ($asc_perform as $perfomr)
            <div class="m-1 " style="width: 10.4% !important; font-size: 0.8rem">
                @foreach ($priorities as $pro)
                @if($pro['function_id'] == $perfomr['function_id'])
                <div class="@if( $pro['priority']<=0.6) bg-success text-white @elseif($pro['priority']>0.6 && $pro['priority']<=0.8) bg-warning text-black @else bg-danger text-white @endif"
                    style="border-radius: 10px;     display: flex;
    justify-content: center;
    align-content: center;
    flex-direction: column;
    text-align: center;
    height: 2rem;
    font-size: 1rem;">
                    @if( $pro['priority']<=0.6) Low @elseif($pro['priority']>0.6 && $pro['priority']<=0.8) Medium @else
                            High @endif </div>

                            @break
                            @endif
                            @endforeach
                </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-sm-1 m-1 text-white" style="font-size: 0.84rem;
    border: 4px solid #376092;
    background-color: #376092;
    border-radius: 10px;
    display: flex;
    justify-content: center;
    align-content: center;
    flex-direction: column;
    text-align: center;">

                    <span>Key improvement areas by practices
                    </span>
                </div>
                @foreach ($asc_perform as $perfomr)
                <?php $count=0; ?>
                <div class="m-1 " style="width: 10.4% !important; font-size: 0.8rem">
                    <ul class="list-group" style="width: 100%; border-radius: 10px;">
                        @foreach ( $overAllpractice as $practice)
                        @if($practice['function_id'] == $perfomr['function_id'])
                        <li class="list-group-item list-group-item p-2 text-center">
                            {{ $practice['name'] }}
                        </li>
                        <?php $count++; ?>
                        @endif
                        @if($count==3)
                        @break;
                        @endif
                        @endforeach
                    </ul>
                </div>
                @endforeach
            </div>
        </div>
        <div class="card-footer">
            <span class="legend-result"><b>Legend:</b></span> <span class="legend-levels"><b> Leadership:</b></span>
            <img src="{{ asset('assets/img/icon/LeadersIcon.png') }}" height="20" width="25" alt=""> – <span
                class="legend-levels"><b>HR Team:</b></span> <img src="{{ asset('assets/img/icon/HRIcon.png') }}"
                height="20" width="25" alt=""> – <span class="legend-levels"><b>Employee:</b></span> <img
                src="{{ asset('assets/img/icon/EmployeIcon.png') }}" height="20" width="25" alt="">

        </div>
    </div>
    <button id="heatmapDownload" class="btn btn-success mt-1" style="border-radius: 10px;
    -webkit-box-shadow: 5px 5px 20px 5px #ababab;
    box-shadow: 5px 5px 20px 5px #ababab;" onclick="downloadResult('Consolidated','Consolidated')">Download
        Consolidated</button>
    <div class="row text-start">
        <div class="col-4 p-3 ">

            <button id="DownloadAll" class="btn btn-success mt-3" style="border-radius: 10px;
    -webkit-box-shadow: 5px 5px 20px 5px #ababab;
    box-shadow: 5px 5px 20px 5px #ababab;">Download
                All Graph</button>
        </div>
        <div class="col-4 p-3 ">

            <a href="{{ route('surveys.DownloadSurvey',$id) }}" class="btn btn-success mt-3" style="border-radius: 10px;
    -webkit-box-shadow: 5px 5px 20px 5px #ababab;
    box-shadow: 5px 5px 20px 5px #ababab;">Download Survey Answers</a>
        </div>
        <div class="col-4 p-3 ">

            <a href="{{ route('surveys.DownloadPriorities',$id) }}" class="btn btn-success mt-3" style="border-radius: 10px;
    -webkit-box-shadow: 5px 5px 20px 5px #ababab;
    box-shadow: 5px 5px 20px 5px #ababab;">Download Priorities Answers</a>
        </div>
    </div>
</div>
</div>
</div>
@endsection
@section('scripts')
{{-- <script src="{{ asset('assets/js/libs/jszip.min.js') }}"></script>
<script src="{{ asset('assets/js/dist/pptxgen.min.js') }}"></script> --}}
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js">
</script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.esm.js">
</script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.js">
</script>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    Labels= @json($function_Lables);
    Leaders= @json($leaders_perform_only);
    hr=@json($hr_perform_only);
    const ctx = document.getElementById('myChart');

const myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: Labels,
        datasets: [
            {
            label: 'Leadership responses',
            data: Leaders,
            backgroundColor: [
                'rgba(0, 74, 159, 1)'//,
                // 'rgba(54, 162, 235, 0.2)',
                // 'rgba(255, 206, 86, 0.2)',
                // 'rgba(75, 192, 192, 0.2)',
                // 'rgba(153, 102, 255, 0.2)',
                // 'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(0, 74, 159, 1)'//,
                // 'rgba(54, 162, 235, 1)',
                // 'rgba(255, 206, 86, 1)',
                // 'rgba(75, 192, 192, 1)',
                // 'rgba(153, 102, 255, 1)',
                // 'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        },
            {
            label: 'HR responses',
            data: hr,
            backgroundColor: [
                // 'rgba(255, 99, 132, 0.2)',
                // 'rgba(54, 162, 235, 0.2)',
                // 'rgba(255, 206, 86, 0.2)',
                // 'rgba(75, 192, 192, 0.2)',
                // 'rgba(153, 102, 255, 0.2)',
                'rgba(0, 153, 204,1)'
            ],
            borderColor: [
                // 'rgba(255, 99, 132, 1)',
                // 'rgba(54, 162, 235, 1)',
                // 'rgba(255, 206, 86, 1)',
                // 'rgba(75, 192, 192, 1)',
                // 'rgba(153, 102, 255, 1)',
                'rgba(0, 159, 204, 1)'
            ],
            borderWidth: 1
        },
    ]
    },
    options: {
        scales: {
            y: {
                suggestedMin: 0,
                suggestedMax: 100,
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Score'
                }
            }
        }
    }
});
$("#DownloadAll").click(function(){
    window.setTimeout(function(){
                 // do whatever you want to do
                 downloadResult('Function','Function' )
                  }, 3000);
    window.setTimeout(function(){
                 // do whatever you want to do
                 downloadResult('key','Dashboard' )
                  }, 3000);
    window.setTimeout(function(){
                 // do whatever you want to do
                 downloadResult('Laverages','Leadership_View_Average' )
                  }, 3000);
    window.setTimeout(function(){
                 // do whatever you want to do
                 downloadResult('HRaverages','HR_View_Average' )
                  }, 3000);
                  window.setTimeout(function(){
                             // do whatever you want to do
                             downloadResult('Empaverages','Employee_View_Average' )
                              }, 3000);
                window.setTimeout(function(){
                             // do whatever you want to do
                             downloadResult('heatmap','heatmap' )
                              }, 3000);
                window.setTimeout(function(){
                             // do whatever you want to do
                             downloadResult('Linear','Linear' )
                              }, 3000);
                window.setTimeout(function(){
                             // do whatever you want to do
                             downloadResult('Consolidated','Consolidated' )
                              }, 3000);
                });

                // $("#heatmapDownload").click(function() {

    //     html2canvas(document.getElementById("heatmap")).then(function(canvas) {
    //         downloadImage(canvas.toDataURL(), "heatmap.png");
    //     });


    // });
    // $("#FunctionDownload").click(function() {

    //     html2canvas(document.getElementById("Function")).then(function(canvas) {
    //         downloadImage(canvas.toDataURL(), "Function.png");
    //     });


    // });
    // $("#keyDownload").click(function() {

    //     html2canvas(document.getElementById("key")).then(function(canvas) {
    //         downloadImage(canvas.toDataURL(), "key.png");
    //     });
// });
    function downloadResult(Resultcard, filename = 'untitled') {
        console.log(Resultcard);
        html2canvas(document.getElementById(Resultcard)).then(function(canvas) {
            downloadImage(canvas.toDataURL(), filename+".png");
        });
    }

    function downloadImage(uri, filename) {
        var link = document.createElement('a');
        if (typeof link.download !== 'string') {
            window.open(uri);
        } else {
            link.href = uri;
            link.download = filename;
            accountForFirefox(clickLink, link);
        }
    }

    function clickLink(link) {
        link.click();
    }

    function accountForFirefox(click) {
        var link = arguments[1];
        document.body.appendChild(link);
        click(link);
        document.body.removeChild(link);
    }
</script>
@endsection
