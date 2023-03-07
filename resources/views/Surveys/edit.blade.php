{{-- extends --}}
@extends('layouts.main')

{{-- content --}}
{{-- create survey with validation --}}
@section('content')
<div class="container pt-5 mt-5">
    <div class="row">
        <div class="col-3">
            <!-- side bar menu -->
            @include('layouts.sidebar')
        </div>
        <div class="col-9">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h3 class="card-title">Create Survey</h3>
                        </div>
                        {{-- add new survey button --}}
                        <div class="col-6 text-end">
                            <a href="{{ route('clients.show',$survey->ClientId) }}" class="btn btn-primary btn-sm">Back</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <p>Create Survey</p>
                    {{-- list all errors --}}
                    @if ($errors->any())
                    {!! implode('', $errors->all('<span class="text text-danger">:message</span>')) !!}
                    @endif
                    <form action="{{ route('surveys.update',$survey->id) }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="SurveyTitle">Survey Title</label>
                            <input type="text" class="form-control @error('SurveyTitle') is-invalid @enderror"
                                id="SurveyTitle" name="SurveyTitle" placeholder="Enter Survey Title" value="{{ old('SurveyTitle',$survey->SurveyTitle) }}">
                            @error('SurveyTitle')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="PlanId">Plan Name</label>
                            <select class="form-control @error('PlanId') is-invalid @enderror" id="PlanId" name="PlanId"
                                required>
                                <option value="">Select Plan</option>
                                @foreach ($plans as $plan)
                                <option value="{{ $plan->id }}" @if($plan->id== old('PlanId',$survey->PlanId)) selected @endif>{{ $plan->PlanTitle }}</option>
                                @endforeach
                            </select>
                            @error('PlanId')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="ClientId">Client Name</label>
                            <select class="form-control @error('ClientId') is-invalid @enderror" id="ClientId"
                                name="ClientId" disabled>
                                <option value="">Select Client</option>
                                @foreach ($clients as $client)
                                <option value="{{ $client->id }}" @if($client->id==old('ClientId',$survey->ClientId)) selected @endif>{{
                                    $client->ClientName }}</option>
                                @endforeach
                            </select>
                            @error('ClientId')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="SurveyDes">Survey Description</label>
                            <input type="text" class="form-control @error('SurveyDes') is-invalid @enderror"
                                id="SurveyDes" name="SurveyDes" placeholder="Enter Survey Description" value="{{ old('SurveyDes',$survey->SurveyDes) }}">
                            @error('SurveyDes')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="SurveyStat">Survey Status</label>
                            <select class="form-control @error('SurveyStat') is-invalid @enderror" required
                                id="SurveyStat" name="SurveyStat">
                                <option value="1" @if(old('SurveyStat',$survey->SurveyStat)==1) selected @endif>Active</option>
                                <option value="0" @if(old('SurveyStat',$survey->SurveyStat)==0) selected @endif>Inactive</option>
                            </select>
                            @error('SurveyStat')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        {{-- submit button --}}
                        <div class="form-group text-end mt-1">
                            <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    //on from submit
    $('form').submit(function () {
        //disable client id
        $('#ClientId').attr('disabled', false);
    });
</script>
@endsection
