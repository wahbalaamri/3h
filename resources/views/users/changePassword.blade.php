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
                    <h3 class="card-title float-start">{{ 'change User Password' }}</h3>
                    <a href="{{ route('users.index') }}" class="btn btn-primary float-end">Back</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.storeNewPass', $id) }}" method="POST" id="form">
                        @csrf
                        {{-- old password with eye --}}
                        {{-- <div class="row">
                            @if($errors->any())
                            {!! implode('', $errors->all('<div class="text-danger">:message</div>')) !!}
                            @endif
                        </div> --}}
                        <div class="row justify-content-center">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="old_password">Old Password</label>
                                    <div class="input-group">
                                        <input type="password" name="old_password" id="old_password"
                                            class="form-control @error('old_password') is-invalid @enderror"
                                            placeholder="Enter Old Password">
                                        <div class="input-group-text">
                                            <i class="fas fa-eye" onclick="showpass(this)"></i>
                                        </div>
                                    </div>
                                    @error('old_password')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        {{-- new password with eye --}}
                        <div class="row justify-content-center">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="new_password">New Password</label>
                                    <div class="input-group">
                                        <input type="password" name="new_password" id="new_password"
                                            class="form-control @error('new_password') is-invalid @enderror"
                                            placeholder="Enter New Password">
                                        <div class="input-group-text">
                                            <i class="fas fa-eye" onclick="showpass(this)"></i>
                                        </div>
                                    </div>
                                    @error('new_password')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        {{-- confirm password with eye --}}
                        <div class="row justify-content-center">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="confirm_password">Confirm Password</label>
                                    <div class="input-group">
                                        <input type="password" name="confirm_password" id="confirm_password"
                                            class="form-control @error('confirm_password') is-invalid @enderror"
                                            placeholder="Enter Confirm Password">
                                        <div class="input-group-text">
                                            <i class="fas fa-eye" onclick="showpass(this)"></i>
                                        </div>
                                    </div>
                                    @error('confirm_password')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        {{-- submit button --}}
                        <div class="row justify-content-center">
                            <div class="col-6">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary float-end mt-2">Change
                                        Password</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    showpass=(current)=>{
        let input = current.parentElement.parentElement.children[0];
        if(input.type=='password'){
            input.type='text';
            current.classList.remove('fa-eye');
            current.classList.add('fa-eye-slash');
        }else{
            input.type='password';
            current.classList.remove('fa-eye-slash');
            current.classList.add('fa-eye');
        }
    }
</script>
@endsection
