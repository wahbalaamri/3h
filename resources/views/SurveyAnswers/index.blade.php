{{-- surveys answers --}}
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
                        @if (count($surveys) > 0)
                            @foreach ($surveys as $survey)
                                <a href="{{ route('survey-answers.result',$survey->id) }}" class="btn btn-primary m-2">{{ $survey->SurveyTitle }} for {{ $survey->clients->ClientName }} Using plan {{ $survey->plan->PlanTitle }}</a>
                            @endforeach
                        @endif
                    </div>
                </div>
                {{-- card --}}@if (count($free_surveys) > 0)
                    <div class="card mt-3">
                        {{-- card header --}}
                        <div class="card-header">
                            <h3>Free Survey Answers</h3>
                        </div>
                        {{-- card body --}}
                        <div class="card-body">
                            {{-- survey divs --}}

                            @foreach ($free_surveys as $survey)
                                <a href="{{ route('survey-answers.freeSurveyResult',$survey->SurveyId) }}" class="btn btn-sm btn-primary m-3">{{ $survey->SurveyId }}</a>
                            @endforeach

                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
