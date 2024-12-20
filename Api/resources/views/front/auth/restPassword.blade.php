@extends('front.layouts.appAuth')
@section('title', 'Password Reminder Page')
@section('authContent')
    <div class="row justify-content-center push">
        <div class="col-md-8 col-lg-6 col-xl-4">
            <div class="block block-rounded mb-0">
                <div class="block-header block-header-default">
                    <h3 class="block-title">{{ __('Password Reminder') }}</h3>
                    <div class="block-options">
                        <a class="btn-block-option fs-sm" href="{{ route('front.login') }}">{{ __('Back to login') }}</a>
                    </div>
                </div>
                <div class="block-content">
                    <div class="p-sm-3 px-lg-4 px-xxl-5 py-lg-5">
                        @if (Session::has('message'))
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-{!! Session::get('alert-type') !!}">
                                        {!! Session::get('message') !!}
                                    </div>
                                </div>
                            </div>
                        @endif
                        <h1 class="h2 mb-1">{{ __('OneUI') }}</h1>
                        <p class="fw-medium text-muted">
                            {{ __('Please provide your account’s email or username and we will send you your
                            password.') }}
                        </p>
                        <form class="js-validation-reminder mt-4" action="{{ route('front.sendLinkToUser') }}"
                            method="POST">
                            @csrf
                            <div class="mb-4">
                                <input type="text" class="form-control form-control-lg form-control-alt"
                                    id="reminder-credential" name="email" placeholder="Username or Email">
                                <span class="help-block">
                                    <font color="red">
                                        {{ @$message }}
                                        {{ $errors->has('email') ? '' . $errors->first('email') . '' : '' }}
                                    </font>
                                </span>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-6 col-xl-5">
                                    <button type="submit" class="btn w-100 btn-alt-primary">
                                        <i class="fa fa-fw fa-envelope me-1 opacity-50"></i> {{ __('Send Mail') }}
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
