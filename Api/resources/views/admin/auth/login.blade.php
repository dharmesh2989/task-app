@extends('admin.layouts.appAuth')
@section('title', 'Login Page')
@section('authContent')
    <div class="row justify-content-center push">
        <div class="col-md-8 col-lg-6 col-xl-4">
            <div class="block block-rounded mb-0">
                <div class="block-header block-header-default">
                    <h3 class="block-title">{{ __('Sign In') }}</h3>
                    <div class="block-options">
                        <a class="btn-block-option fs-sm"
                            href="{{ route('admin.resetPassword') }}">{{ __('Forgot Password?') }}</a>
                    </div>
                </div>
                <div class="block-content">
                    <div class="p-sm-3 px-lg-4 px-xxl-5 py-lg-5">
                        <h1 class="h2 mb-1">{{ __('OneUI') }}</h1>
                        <p class="fw-medium text-muted">
                            {{ __('Welcome, please login.') }}
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
                        <form class="js-validation-signin" action="{{ route('admin.login') }}" method="POST">
                            @csrf
                            <div class="py-3">
                                <div class="mb-4">
                                    <input type="text" class="form-control form-control-alt form-control-lg"
                                        id="login-username" name="email" placeholder="email">
                                    <span class="help-block">
                                        <font color="red">
                                            {{ $errors->has('email') ? '' . $errors->first('email') . '' : '' }} </font>
                                    </span>
                                </div>
                                <div class="mb-4">
                                    <input type="password" class="form-control form-control-alt form-control-lg"
                                        id="login-password" name="password" placeholder="Password">
                                    <span class="help-block">
                                        <font color="red">
                                            {{ $errors->has('password') ? '' . $errors->first('password') . '' : '' }}
                                        </font>
                                    </span>
                                </div>
                                <div class="mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="login-remember"
                                            name="login-remember">
                                        <label class="form-check-label" for="login-remember">{{ __('Remember Me') }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-6 col-xl-5">
                                    <button type="submit" class="btn w-100 btn-alt-primary">
                                        <i class="fa fa-fw fa-sign-in-alt me-1 opacity-50"></i> {{ __('Sign In') }}
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
