@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                {{--  404 error page --}}
                <h1>Survey was taken </h1>
                <h3>You already took the survey</h3>
                <a href="{{ url('/') }}">Back to home</a>
            </div>
        </div>
    </div>
@endsection
