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
            {{-- card to display all users --}}
            <div class="card pb-5 mb-5">
                <div class="card-header">
                    <h3 class="card-title float-start">{{ $user==null? 'Add New User': 'Edit User Details' }}</h3>
                    <a href="{{ route('users.index') }}" class="btn btn-primary float-end">Back</a>
                </div>
                <div class="card-body">
                    <form action="{{ $user==null? route('users.store'): route('users.update', $user->id) }}"
                        method="POST" id="form">
                        @csrf
                        @if ($user!=null)
                        @method('PUT')
                        @endif
                        {{-- <div class="row">
                            @if ($errors->any())
                            @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                            @endforeach
                            @endif
                        </div> --}}
                        <div class="row">
                            {{-- select user client --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="user_client"> Select Company</label>
                                    <select name="user_client" id="user_client"
                                        class="form-control @error('user_client') is-invalid @enderror" {{
                                        Auth()->user()->company_id!=null? 'disabled': '' }}>
                                        <option value="">Select Company</option>
                                        @foreach ($clients as $client)
                                        <option value="{{ $client->id }}" {{ old('user_client',Auth()->
                                            user()->company_id)==$client->id? 'selected': '' }}>{{ $client->ClientName
                                            }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('user_client')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            {{-- user Type --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="user_type">User Type</label>
                                    <select name="user_type" id="user_type"
                                        class="form-control @error('user_type') is-invalid @enderror">
                                        <option value="">Select User Type</option>
                                        @if(Auth()->user()->company_id==null)
                                        <option value="superadmin" {{ old('user_type',$user!=null && $user->
                                            user_type)=='superadmin'?
                                            'selected':
                                            '' }}>Super Admin</option>
                                        @endif
                                        <option value="admin" {{ old('user_type',$user!=null ? $user->
                                            user_type:'')=='admin'? 'selected':
                                            '' }}>Admin</option>
                                        <option value="user" {{ old('user_type',$user!=null ? $user->
                                            user_type:'')=='user'? 'selected': ''
                                            }}>User</option>
                                    </select>
                                    @error('user_type')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            {{-- user name --}}
                            <div class="col-6">
                                <div class="form-group mt-2">
                                    <label for="name" class="mb-2">User Name</label>
                                    <input type="text" class="form-control @error('user_name') is-invalid @enderror"
                                        name="user_name" placeholder="Enter User Name" id="user_name"
                                        value="{{ old('user_name',$user!=null? $user->name:"") }}">
                                    @error('user_name')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            {{-- user Email --}}
                            <div class="col-6">
                                <div class="form-group mt-2">
                                    <label for="name" class="mb-2">User Email<small><mark
                                                class="text-info text-xs fs-6 text-uppercase"
                                                style="font-size: 0.7rem !important"> it will be used for
                                                login</mark></small></label>
                                    <input type="email" class="form-control @error('user_email') is-invalid @enderror"
                                        name="user_email" placeholder="Enter User Name" id="user_email"
                                        value="{{ old('user_email',$user!=null? $user->email:"") }}">
                                    @error('user_email')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        {{-- submit button --}}
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary mt-2 float-end">{{ $user==null? 'Add User':
                                'Update User' }}</button>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- footer --}}
@section('scripts')
<script>
    $('form').submit(function(){
        console.log("object");
        $("#user_client").attr('disabled', false);
    });
</script>
@endsection

{{-- user controller --}}
