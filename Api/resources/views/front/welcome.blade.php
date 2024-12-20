@extends('front.layouts.app')
@section('title', 'Home Page')
@section('mainContent')
    <div class="content">
        <div class="row">
            <h2 class="h6 fw-medium fw-medium text-muted mb-0">
                {{ __('Welcome') }} {{ Auth::user()->name }}{{ __(', everything looks great.') }}
            </h2>
        </div>
    </div>
@endsection
@section('styles')
@endsection
@section('scripts')
@endsection
