{{-- extends --}}
@extends('layouts.main')

{{-- content --}}
{{-- edit client details --}}
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
                                <h3 class="card-title">Edit Client Details</h3>
                            </div>
                            {{-- back to clients button --}}
                            <div class="col-6 text-end">
                                <a href="{{ route('clients.index') }}" class="btn btn-primary">Back to Clients</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <p>Edit Client Details</p>
                        <form action="{{ route('clients.update', $client->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="ClientName" class="form-label">Client Name</label>
                                <input type="text" class="form-control" id="ClientName" name="ClientName"
                                    value="{{ $client->ClientName }}">
                            </div>
                            <div class="mb-3">
                                <label for="ClientPhone" class="form-label">Client Phone</label>
                                <input type="text" class="form-control" id="ClientPhone" name="ClientPhone"
                                    value="{{ $client->ClientPhone }}">
                            </div>
                            <div class="mb-3">
                                <label for="CilentFPName" class="form-label">Focal Point Name</label>
                                <input type="text" class="form-control" id="CilentFPName" name="CilentFPName"
                                    value="{{ $client->CilentFPName }}">
                            </div>
                            <div class="mb-3">
                                <label for="CilentFPEmil" class="form-label">Focal Point Email</label>
                                <input type="email" class="form-control" id="CilentFPEmil" name="CilentFPEmil"
                                    value="{{ $client->CilentFPEmil }}">
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
