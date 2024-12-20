@extends('admin.layouts.app')
@section('title', 'Dashboard Page')
@section('mainContent')
    <div class="content">
        <div
            class="d-flex flex-column flex-md-row justify-content-md-between align-items-md-center py-2 text-center text-md-start">
            <div class="flex-grow-1 mb-1 mb-md-0">
                <h1 class="h3 fw-bold mb-2">
                    {{ __('Dashboard') }}
                </h1>
                <h2 class="h6 fw-medium fw-medium text-muted mb-0">
                    {{ __('Welcome') }} {{ Auth::user()->name }}{{ __(', everything looks great.') }}
                </h2>
            </div>
        </div>
    </div>
@endsection
@section('styles')
@endsection
@section('scripts')
@endsection
