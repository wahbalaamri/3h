{{-- extends --}}
@extends('layouts.main')

{{-- content --}}
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
                                <h3 class="card-title">Create New Client</h3>
                            </div>
                            {{-- create New Client button --}}
                            <div class="col-6 text-end">
                                <a href="{{ route('clients.index') }}" class="btn btn-primary">Back</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        {{-- create new client form --}}
                        <form action="{{ route('clients.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="ClientName" class="form-label">Client Name</label>
                                        <input type="text" class="form-control @error('ClientName') is-invalid @enderror"
                                            id="ClientName" name="ClientName" placeholder="Client Name">
                                        {{-- validation error --}}
                                        @error('ClientName')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="ClientPhone" class="form-label">Client Phone</label>
                                        <input type="text"
                                            class="form-control @error('ClientPhone') is-invalid @enderror" id="ClientPhone"
                                            name="ClientPhone" placeholder="Client Phone">
                                        {{-- validationerror --}}
                                        @error('ClientPhone')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="CilentFPName" class="form-label">Focal Point Name</label>
                                        <input type="text"
                                            class="form-control @error('CilentFPName') is-invalid @enderror"
                                            id="CilentFPName" name="CilentFPName" placeholder="Focal Point Name">
                                        {{-- validation error --}}
                                        @error('CilentFPName')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="CilentFPEmil" class="form-label">Focal Point Email</label>
                                        <input type="email"
                                            class="form-control  @error('CilentFPEmil') is-invalid @enderror"
                                            id="CilentFPEmil" name="CilentFPEmil" placeholder="Focal Point Email">
                                        {{-- validation error --}}
                                        @error('CilentFPEmil')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-primary">Create</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
