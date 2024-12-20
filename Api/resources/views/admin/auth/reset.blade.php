@extends('admin.layouts.appAuth')
@section('title', 'Reset Password Page')
@section('authContent')
    <div class="row justify-content-center push">
        <div class="col-md-8 col-lg-6 col-xl-4">
            <div class="block block-rounded mb-0">
                <div class="block-header block-header-default">
                    <h3 class="block-title">{{ __('Reset Password') }}</h3>
                    <div class="block-options">
                        <a class="btn-block-option fs-sm" href="{{ route('admin.login') }}">{{ __('Back to login') }}</a>
                    </div>
                </div>
                <div class="block-content">
                    <div class="p-sm-3 px-lg-4 px-xxl-5 py-lg-5">
                        <h1 class="h2 mb-1">{{ __('OneUI') }}</h1>
                        <p class="fw-medium text-muted">
                            {{ __('Please fill the following details to create a new account.') }}
                        </p>
                        @if (Session::has('message'))
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-{!! Session::get('alert-type') !!}">
                                        {!! Session::get('message') !!}
                                    </div>
                                </div>
                            </div>
                        @endif
                        <form class="js-validation-signup" action="{{ route('admin.resetPassword_set') }}" method="POST">
                            @csrf
                            <input type="hidden" name="token" value="{{ $passwordReset->token }}">
                            <div class="py-3">
                                <div class="mb-4">
                                    <input type="email" class="form-control form-control-lg form-control-alt"
                                        id="signup-email" name="email" placeholder="Email">
                                    @error('email')
                                        <span class="help-block">
                                            <font color="red">{{ $message }}</font>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <input type="password" class="form-control form-control-lg form-control-alt"
                                        id="signup-password" name="password" placeholder="Password">
                                    @error('password')
                                        <span class="help-block">
                                            <font color="red">{{ $message }}</font>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <input type="password" class="form-control form-control-lg form-control-alt"
                                        id="signup-password-confirm" name="password_confirmation"
                                        placeholder="Confirm Password">
                                    @error('password')
                                        <span class="help-block">
                                            <font color="red">{{ $message }}</font>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-6 col-xl-6">
                                    <button type="submit" class="btn w-100 btn-alt-primary">
                                        <i class="fa fa-fw fa-plus me-1 opacity-50"></i>
                                        {{ __('Reset Password') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="fs-sm text-muted text-center">
        <strong>{{ __('OneUI 5.4') }}</strong> &copy; <span data-toggle="year-copy"></span>
    </div>
@endsection
@section('authStyles')
@endsection
@section('authScripts')
@endsection
