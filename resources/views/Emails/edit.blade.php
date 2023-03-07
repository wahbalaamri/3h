{{-- extends --}}
@extends('layouts.main')

{{-- content --}}
{{-- Edit email --}}
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
                        <h3 class="card-title">Edit Email</h3>
                    </div>
                    <div class="card-body">
                        <ul>
                            @if ($errors->any())
                                {!! implode('', $errors->all('<li class="text text-danger">:message</li>')) !!}
                            @endif
                        </ul>
                        <form action="{{ route('emails.update', $email->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="SurveyId">Survey ID</label>
                                        <select name="SurveyId" id="SurveyId"
                                            class="form-control @error('SurveyId') is-invalid @enderror">
                                            <option value="">Select Survey</option>
                                            @foreach ($surveys as $survey)
                                                <option value="{{ $survey->id }}"
                                                    @if ($email->SurveyId == $survey->id) selected @endif>
                                                    {{ $survey->SurveyTitle }}</option>
                                            @endforeach
                                        </select>
                                        {{-- validation --}}
                                        @error('SurveyId')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="ClientId">Client ID</label>
                                        <select name="ClientId" id="ClientId"
                                            class="form-control @error('ClientId') is-invalid @enderror" required>
                                            <option value="">Select Client</option>
                                            @foreach ($clients as $client)
                                                <option value="{{ $client->id }}"
                                                    @if ($email->ClientId == $client->id) selected @endif>
                                                    {{ $client->ClientName }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            {{-- edit email details --}}
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="Email">Email</label>
                                        <input type="text" name="Email" id="Email"
                                            class="form-control @error('Email') is-invalid @enderror"
                                            value="{{ $email->Email }}" required>
                                        {{-- validation --}}
                                        @error('Email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="EmployeeType">Employee Type</label>
                                        <select name="EmployeeType" id="EmployeeType"
                                            class="form-control @error('EmployeeType') is-invalid @enderror" required>
                                            <option value="">Select Employee Type</option>
                                            <option value="1" @if ($email->EmployeeType == 1) selected @endif>Manager
                                            </option>
                                            <option value="2" @if ($email->EmployeeType == 2) selected @endif>Hr Team
                                            </option>
                                            <option value="3" @if ($email->EmployeeType == 3) selected @endif>
                                                Employee</option>
                                            {{-- validation --}}
                                            @error('EmployeeType')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="AddedBy" id="AddedBy"
                                value="{{ Auth::user()->user_type == 'superadmin' ? 0 : Auth::user()->company_id }}">
                            <div class="row text-end mt-4">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@endsection
