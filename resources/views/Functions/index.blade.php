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
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="">Search for Functions</h3>
                    </div>
                    <div class="card-body">
                        @if (count($plans) > 0)
                            <form action="{{ route('functions.search') }}" method="post">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-6">
                                        <label for="search">Search</label>
                                        <select id="PlanID" name="PlanID" class="form-control">
                                            <option value="">Select</option>
                                            @foreach ($plans as $plan)
                                                <option value="{{ $plan->id }}">{{ $plan->PlanTitle }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-3 text-start">
                                        <button type="submit" class="btn btn-primary mt-4">Search</button>
                                    </div>
                                </div>
                            </form>
                        @else
                            <div class="alert alert-warning">
                                <h4 class="h4">There is no plan You may need to grab your plans from hrfactoryapp</h4>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Functions</h3>
                    </div>
                    <div class="card-body">
                        <p>Functions</p>
                        {{-- Create Table of Functions --}}
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tr>
                                    <th>#</th>
                                    <th>Function</th>
                                    <th>Respondent</th>
                                    <th>Actions</th>
                                </tr>
                                @foreach ($functions as $function)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $function->FunctionTitle }}</td>
                                        <td>
                                            @switch($function->Respondent)
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
                                        <td>actions</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Remote Functions</h3>
                    </div>
                    <div class="card-body">
                        @if (count($remotFunctions) > 0)
                            <p>Functions</p>
                            {{-- Create Table of Functions --}}
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <tr>
                                        <th>#</th>
                                        <th>Function</th>
                                        <th>Respondent</th>
                                        <th>Actions</th>
                                    </tr>
                                    @foreach ($remotFunctions as $function)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $function->FunctionTitle }}</td>
                                            <td>
                                                @switch($function->Respondent)
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
                                            <td>actions</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                            {{-- pull data button --}}
                            <div class="text-center">
                                <a href="{{ route('functions.save') }}" class="btn btn-primary">Pull Data</a>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
