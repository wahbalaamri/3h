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
                            <h3 class="card-title">{{ __('Open Ended Questions') }}</h3>
                        </div>
                        {{-- add new survey button --}}
                        <div class="col-6 text-end">
                            <a href="{{ route('clients.show',$client_id) }}" class="btn btn-primary btn-sm">Back</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <p>Open Ended Questions</p>
                    {{-- list all errors --}}
                    @if ($errors->any())
                    {!! implode('', $errors->all('<span class="text text-danger">:message</span>')) !!}
                    @endif
                    <form action="{{$id==null? route('surveys.SaveOpenEndedQ',$survey) : route('surveys.UpdateOpenEndedQ',['id'=>$id,'survey'=>$survey]) }}" method="POST">
                        {{-- open ended question in english --}}
                        @csrf
                        <div class="form-group col-lg-8 col-md-9 col-sm-12">
                            <label for="question">
                                {{('Enter The Open Ended Question In English')}}
                        </label>
                            <input type="text" name="question" id="question" class="form-control oe-question"
                                placeholder="Enter The Open Ended Question In English" aria-describedby="helpId_en">
                            <small id="helpId_en" class="text-muted">{{ __('Must Enter') }}</small>
                        </div>
                        {{-- open ended question in arabic --}}
                        <div class="form-group col-lg-8 col-md-9 col-sm-12">
                            <label for="question_ar">
                                {{('Enter The Open Ended Question In Arabic')}}
                        </label>
                            <input type="text" name="question_ar" id="question_ar" class="form-control oe-question"
                                placeholder="Enter The Open Ended Question In Arabic" aria-describedby="helpId_ar">
                            <small id="helpId_ar" class="text-muted">{{ __('Must Enter') }}</small>
                        </div>
                        {{-- open ended question in Hindi --}}
                        <div class="form-group col-lg-8 col-md-9 col-sm-12">
                            <label for="question_in">
                                {{('Enter The Open Ended Question In Hindi')}}
                        </label>
                            <input type="text" name="question_in" id="question_in" class="form-control oe-question"
                                placeholder="Enter The Open Ended Question In Hindi" aria-describedby="helpId_in">
                            <small id="helpId_in" class="text-muted">{{ __('Must Enter') }}</small>
                        </div>
                        {{-- Submit Button --}}
                        <div class="form-group col-lg-8 col-md-9 col-sm-12 text-end">
                            <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
