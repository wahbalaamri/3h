@extends('layouts.main')
@section('content')
{{-- container --}}
<div class="container mt-5 pt-5">
    {{-- row --}}
    <div class="row justify-content-center">
        {{-- col --}}
        <div class="col-md-8">
            {{-- card --}}
            <div class="card">
                {{-- card-header --}}
                <div class="card-header">{{ __('Register') }}</div>
                {{-- card-body --}}
                <div class="card-body">
                    {{-- alert --}}

                        <div class="alert alert-success" role="alert">
                            {{-- header text --}}
                            <h4 class="alert-heading">Self-rgistration still not available</h4>

                        </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
