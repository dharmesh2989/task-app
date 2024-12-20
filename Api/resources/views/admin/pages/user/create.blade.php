@extends('admin.layouts.app')
@section('title')
    Create Users Management
@endsection
@section('mainContent')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-2">
                        {{ __('Users Form Elements') }}
                    </h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">
                        {{ __('Carefully designed elements that will ensure a great experience for your users.') }}
                    </h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('admin.user.index') }}">{{ __('User Table') }}</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            {{ __('User Froms') }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">{{ __('Create User From') }}</h3>
            </div>
            <div class="block-content block-content-full">
                {!! Form::open(['route'	=> ['admin.user.store'],'files' => 'true'])!!}
                @include('admin.pages.user.form')
                <div class="hr-line-dashed"></div>
                <div class="col-sm-6">
                    <div class="form-group row">
                        <div class="col-sm-8 col-sm-offset-8">
                            <button class="btn btn-w-m btn btn-primary" type="submit">{{ __('Save') }}</button>
                            <a href="{{ route('admin.user.index') }}"
                                class="btn btn-w-m btn btn-danger">{{ __('Cancel') }}</a>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
@section('styles')
@endsection
@section('scripts')
@endsection
