@extends('layouts.main')
@section('content')
<div class="container">
    {{-- add card --}}
    <div class="row justify-content-center">
        <div class="col-lg-9 col-md-10 col-sm-12 ">
            <div class="card">
                {{-- card header --}}
                <div class="card-header">
                    <h3>{{__('Survey QR Code')}}</h3>
                </div>
                {{-- card body --}}
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-8 col-md-10 col-sm-12 text-center">
                            {{ $data }}
                        </div>
                    </div>
                    {{-- create from that tack Email Address, Mobile & Employee ID --}}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
