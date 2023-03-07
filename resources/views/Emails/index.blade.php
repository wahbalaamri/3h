{{-- extends --}}
@extends('layouts.main')

{{-- content --}}
{{-- Emails List --}}
@section('content')
    <div class="container pt-5 mt-5">
        <div class="row">
            <div class="col-3">
                <!-- side bar menu -->
                @include('layouts.sidebar')
            </div>
            <div class="col-9">
                {{-- search for emails using survey id and client id --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">search for emails</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('emails.search') }}" method="POST" class="d-inline">
                            @csrf
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="SurveyID">Survey ID</label>
                                        <select name="SurveyID" id="SurveyID" class="form-control" required>
                                            <option value="">Select Survey</option>
                                            @foreach ($surveys as $survey)
                                                <option value="{{ $survey->id }}">{{ $survey->SurveyTitle }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="ClientID">Client ID</label>
                                        <select name="ClientID" id="ClientID" class="form-control" required>
                                            <option value="">Select Client</option>
                                            @foreach ($clients as $client)
                                                <option value="{{ $client->id }}">{{ $client->ClientName }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row text-end mt-1">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <h3 class="card-title">Emails</h3>
                            </div>
                            {{-- add new email button --}}
                            <div class="col-6 text-end">
                                <a href="{{ route('emails.create') }}" class="btn btn-primary">Add New Email</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <p>Emails List</p>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Email Name</th>
                                    <th scope="col">Company (Client Name)</th>
                                    <th scope="col">Survey</th>
                                    <th scope="col">Employee Type</th>
                                    <th scope="col">Added By</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($emails as $email)
                                    <tr>
                                        <td>{{ $email->Email }}</td>
                                        <td>{{ $email->clients->ClientName }}</td>
                                        <td>{{ $email->survey->SurveyTitle }}</td>
                                        <td>
                                            @switch($email->EmployeeType)
                                                @case(1)
                                                    Manager
                                                @break

                                                @case(2)
                                                    HR Team
                                                @break

                                                @case(3)
                                                    Employee
                                                @break

                                                @default
                                            @endswitch
                                        </td>
                                        <td>{{ $email->AddedBy == 0 ? 'system' : 'user' }}</td>
                                        <td>

                                            <a href="{{ route('emails.edit', $email->id) }}"
                                                class="btn btn-primary">Edit</a>
                                            <form action="{{ route('emails.destroy', $email->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
