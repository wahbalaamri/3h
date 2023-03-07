{{-- not complet answers --}}
{{-- extends --}}
@extends('layouts.main')
{{-- content --}}
@section('content')
    {{-- container --}}
    <div class="container pt-5 mt-5">
        <div class="row">
            <div class="col-3">
                <!-- side bar menu -->
                @include('layouts.sidebar')
            </div>
            <div class="col-9">
                {{-- card --}}
                <div class="card">
                    {{-- card header --}}
                    <div class="card-header">
                        <h3>Survey Answers</h3>
                    </div>
                    {{-- card body --}}
                    <div class="card-body">
                        {{-- survey divs --}}
                        @if($total>0)
                        <div class="col-3 text-end function-lable">Total Answers {{ $total_answers }} out of {{ $total }}</div>
                            <div class="col-9 text-start function-progress">
                                <div class="progress" style="height: 31px">
                                    <div class="progress-bar @if(($total_answers/$total)<0.5) bg-danger @elseif(($total_answers/$total)==1) bg-success @else bg-warning @endif" role="progressbar"
                                        style="width: {{ ($total_answers/$total)*100 }}%; font-size: 1rem" aria-valuenow="{{ ($total_answers/$total)*100 }}" aria-valuemin="0"
                                        aria-valuemax="100">{{ ($total_answers/$total)*100 }}%</div>
                                </div>
                            </div>
                        @endif
                            @if($leaders>0)
                        <div class="col-3 text-end function-lable">Total Leaders Answers {{ $leaders_answers }} out of {{ $leaders }}</div>
                            <div class="col-9 text-start function-progress">
                                <div class="progress" style="height: 31px">
                                    <div class="progress-bar @if(($leaders_answers/$leaders)<0.5) bg-danger @elseif(($leaders_answers/$leaders)==1) bg-success @else bg-warning @endif" role="progressbar"
                                        style="width: {{ ($leaders_answers/$leaders)*100 }}%; font-size: 1rem" aria-valuenow="{{ ($leaders_answers/$leaders)*100 }}" aria-valuemin="0"
                                        aria-valuemax="100">{{ ($leaders_answers/$leaders)*100 }}%</div>
                                </div>
                            </div>
                            @endif
                            @if($hr>0)
                        <div class="col-3 text-end function-lable">Total HR Answers {{ $hr_answers }} out of {{ $hr }}</div>
                            <div class="col-9 text-start function-progress">
                                <div class="progress" style="height: 31px">
                                    <div class="progress-bar @if(($hr_answers/$hr)<0.5) bg-danger @elseif(($hr_answers/$hr)==1) bg-success @else bg-warning @endif" role="progressbar"
                                        style="width: {{ ($hr_answers/$hr)*100 }}%; font-size: 1rem" aria-valuenow="{{ ($hr_answers/$hr)*100 }}" aria-valuemin="0"
                                        aria-valuemax="100">{{ ($hr_answers/$hr)*100 }}%</div>
                                </div>
                            </div>
                            @endif
                            @if($emp>0)
                        <div class="col-3 text-end function-lable">Total Employee Answers {{ $emp_answers }} out of {{ $emp }}</div>
                            <div class="col-9 text-start function-progress">
                                <div class="progress" style="height: 31px">
                                    <div class="progress-bar @if(($emp_answers/$emp)<0.5) bg-danger @elseif(($emp_answers/$emp)==1) bg-success @else bg-warning @endif" role="progressbar"
                                        style="width: {{ ($emp_answers/$emp)*100 }}%; font-size: 1rem" aria-valuenow="{{ ($emp_answers/$emp)*100 }}" aria-valuemin="0"
                                        aria-valuemax="100">{{ ($emp_answers/$emp)*100 }}%</div>
                                </div>
                            </div>
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
