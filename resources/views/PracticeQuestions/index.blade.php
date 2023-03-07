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
                {{-- card to search for questions --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="">Search for Questions</h3>
                    </div>
                    <div class="card-body">
                        @if (count($plans) > 0)
                            <form action="{{ route('practice-questions.search') }}" method="post">
                                @csrf
                                <div class="form-group row">
                                    {{-- plan Select --}}
                                    <div class="col-6">
                                        <label for="search">Plan</label>
                                        <select id="PlanID" name="PlanID" class="form-control">
                                            <option value="">Select</option>
                                            @foreach ($plans as $plan)
                                                <option value="{{ $plan->id }}">{{ $plan->PlanTitle }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    {{-- function Select --}}
                                    <div class="col-6">
                                        <label for="search">Function</label>
                                        <select id="FunctionID" name="FunctionID" class="form-control">
                                            <option value="">Select</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {{-- function practice list --}}
                                    <div class="col-6">
                                        <label for="search">Practice List</label>
                                        <select id="PracticeListID" name="PracticeListID" class="form-control">
                                            <option value="">Select</option>
                                        </select>
                                    </div>
                                    <div class="col-3 text-start">
                                        <button type="submit" class="btn btn-primary mt-4">Search</button>
                                    </div>
                                </div>
                            </form>
                        @else
                            <div class="alert alert-warning">
                                <h4 class="h4">There is no function You may need to grab your functions from
                                    hrfactoryapp</h4>
                            </div>
                        @endif
                    </div>
                </div>
                {{-- card for Questions list --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="">Questions List</h3>
                    </div>
                    <div class="card-body">
                        @if (count($PracticeQuestions) > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Question</th>
                                            <th>Respondent</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($PracticeQuestions as $question)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $question->Question }}</td>
                                                <td>
                                                    @switch($question->Respondent)
                                                        @case(1)
                                                            Only HR Employees
                                                        @break

                                                        @case(2)
                                                            Only Employees
                                                        @break

                                                        @case(3)
                                                            Only Managers
                                                        @break

                                                        @case(4)
                                                            Only HR Employees & Employees
                                                        @break

                                                        @case(5)
                                                            Only Managers & Employees
                                                        @break

                                                        @case(6)
                                                            Only Managers & HR Employees
                                                        @break

                                                        @case(7)
                                                            All Employees
                                                        @break

                                                        @case(8)
                                                            Public
                                                        @break

                                                        @default
                                                            Default case...
                                                    @endswitch
                                                </td>
                                                <td></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="">Remote Questions List</h3>
                    </div>
                    <div class="card-body">
                        @if (count($remotePracticesQuestions) > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Question</th>
                                            <th>Respondent</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($remotePracticesQuestions as $question)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $question->Question }}</td>
                                                <td>
                                                    @switch($question->Respondent)
                                                        @case(1)
                                                            Only HR Employees
                                                        @break

                                                        @case(2)
                                                            Only Employees
                                                        @break

                                                        @case(3)
                                                            Only Managers
                                                        @break

                                                        @case(4)
                                                            Only HR Employees & Employees
                                                        @break

                                                        @case(5)
                                                            Only Managers & Employees
                                                        @break

                                                        @case(6)
                                                            Only Managers & HR Employees
                                                        @break

                                                        @case(7)
                                                            All Employees
                                                        @break

                                                        @case(8)
                                                            Public
                                                        @break

                                                        @default
                                                            Default case...
                                                    @endswitch
                                                </td>
                                                <td></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{-- Save data button --}}
                            <div class="row">
                                <div class="col-12 text-end">
                                    <form action="{{ route('practice-questions.save',$functionID) }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Save Data</button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
{{-- script --}}
@section('script')
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // get function list
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
            // get practice list
            $('#FunctionID').change(function() {
                var FunctionID = $(this).val();
                if (FunctionID) {
                    $.ajax({
                        type: "GET",
                        url: "{{ url('/practice-questions/GetPractice') }}/" + FunctionID,
                        success: function(res) {
                            if (res) {
                                $("#PracticeListID").empty();
                                $("#PracticeListID").append('<option>Select</option>');
                                $.each(res, function(key, value) {
                                    $("#PracticeListID").append('<option value="' +
                                        value.id + '">' + value.PracticeTitle +
                                        '</option>');
                                });
                            } else {
                                $("#PracticeListID").empty();
                            }
                        }
                    });
                } else {
                    $("#PracticeListID").empty();
                }
            });
        });
    </script>
