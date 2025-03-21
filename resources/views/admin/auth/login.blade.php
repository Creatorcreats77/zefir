@extends('client.layouts.app')
@section('title')
    @lang('app.login')
@endsection
@section('content')
    <div class="container-xxl py-4">
        <div class="row justify-content-center">
            <div class="col-10 col-sm-8 col-md-6 col-lg-4 col-xl-3">
                <div class="h4 text-center mb-3">
                    @lang('app.login')
                </div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="username" class="form-label fw-semibold">
                            @lang('app.username') <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror" id="username"
                               name="username" value="{{ old('username') }}" required autofocus>
                        @error('username')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">
                            @lang('app.password') <span class="text-danger">*</span>
                        </label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                               id="password" name="password" value="{{ old('password') }}" required>
                        @error('password')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi-box-arrow-in-down-right"></i>
                        @lang('app.login')
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
