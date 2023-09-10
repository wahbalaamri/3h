{{-- extend --}}
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
                                <h3 class="card-title">{{ __('List of Clients') }}</h3>
                            </div>
                            {{-- create New Client button --}}
                            <div class="col-6 text-end">
                                <a href="{{ route('clients.create') }}" class="btn btn-primary">{{ __('Add New Client') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <p>{{ __('Clients') }}</p>
                        @if (count($clients) > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Client Name') }}</th>
                                            <th>{{ __('Focal Point') }}</th>
                                            <th>{{ __('Phone Number') }}</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($clients as $client)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $client->ClientName }}</td>
                                                <td>{{ $client->CilentFPName }}</td>
                                                <td>{{ $client->ClientPhone }}</td>
                                                <td>
                                                    {{-- view --}}
                                                    <a href="{{ route('clients.show', $client->id) }}"
                                                        class="btn btn-primary">{{ __('View') }}</a>
                                                    {{-- edit --}}
                                                    <a href="{{ route('clients.edit', $client->id) }}"
                                                        class="btn btn-success">{{ __('Edit') }}</a>
                                                    {{-- delete --}}
                                                    <form action="{{ route('clients.destroy', $client->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            {{-- if no clients --}}
                            <p>{{ __('No Clients Found') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
