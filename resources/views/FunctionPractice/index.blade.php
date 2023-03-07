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
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Search for Function Practices</h3>
                    </div>
                    <div class="card-body">
                        <p>search Function Practices</p>
                        {{-- create search for function practices --}}
                        <form action="{{ route('function-practice.search') }}" method="post">
                            @csrf
                            <div class="form-group row">
                                <div class="col-6">
                                    <label for="search">Plans</label>
                                    <select id="PlanID" name="PlanID" class="form-control">
                                        <option value="">Select</option>
                                        @foreach ($plans as $Plan)
                                            <option value="{{ $Plan->id }}">{{ $Plan->PlanTitle }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-6">
                                    <label for="search">Function</label>
                                    <select id="FunctionID" name="FunctionID" required class="form-control">
                                    </select>
                                </div>

                                <div class="col-3 text-start">
                                    <button type="submit" class="btn btn-primary mt-4">Search</button>
                                </div>
                            </div>
                    </div>
                </div>
                {{-- card for all function practices --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">All Function Practices</h3>
                    </div>
                    <div class="card-body">
                        <p>all Function Practices</p>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>

                                        <th>Practice</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($functionPractices as $functionPractice)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $functionPractice->PracticeTitle }}</td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- card for all remote function practices --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">All Remote Function Practices</h3>
                    </div>
                    <div class="card-body">
                        <p>all Remote Function Practices</p>
                        @if (count($remoteFunctionPractices))
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>

                                            <th>Practice</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($remoteFunctionPractices as $remoteFunctionPractice)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $remoteFunctionPractice->PracticeTitle }}</td>
                                                <td></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{-- pull data --}}
                            <div class="text-center">
                                <a href="{{ route('function-practice.save') }}" class="btn btn-primary">Pull Data</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- script --}}
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>

@section('script')
    <script>
        $(document).ready(function() {
            $('#PlanID').change(function() {
                var PlanID = $(this).val();
                if (PlanID) {
                    $.ajax({
                        type: "GET",
                        url: "{{ url('/function-practice/GetFunctions') }}/" + PlanID,
                        success: function(res) {
                            if (res) {
                                $("#FunctionID").empty();
                                $("#FunctionID").append('<option>Select</option>');
                                $.each(res, function(key, value) {
                                    $("#FunctionID").append('<option value="' + value
                                        .id + '">' + value.FunctionTitle +
                                        '</option>');
                                });
                            } else {
                                $("#FunctionID").empty();
                            }
                        }
                    });
                } else {
                    $("#FunctionID").empty();
                }
            });
        });
    </script>
