@extends('admin.layouts.app')
@section('title')
    Edit Proile Management
@endsection
@section('mainContent')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-2">{{ __('Profile Form Elements') }}</h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">
                        {{ __('Carefully designed elements that will ensure a great experience for your users.') }}
                    </h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item"><a class="link-fx"
                                href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item" aria-current="page">{{ __('Profile Froms') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">{{ __('Profile update') }}</h3>
                    </div>
                    <div class="block-content">
                        {!! Form::model($user, [
                            'method' => 'post',
                            'files' => true,
                            'route' => ['admin.updateProfileDetail', $user->id],
                        ]) !!}
                        <div class="mb-4">
                            <div id="imagePreview">
                                @if (!empty(Auth::user()->avatar))
                                    <center>
                                        <img src="{!! Auth::user()->avatar !== '' ? url('storage/user/' . Auth::user()->avatar) : url('storage/user/user.png') !!}" alt="user-img" class="img-circle">
                                    </center>
                                @else
                                    <center>
                                        <img src="{!! url('storage/user/user.png') !!}" name="avatar" alt="user-img" class="img-circle"
                                            accept="image/*">
                                    </center>
                                @endif
                                <span>
                                    <center>
                                        <div class="invalid-feedback">{{ $errors->has('avatar') ? '' . $errors->first('avatar') . '' : '' }}</div>
                                    </center>
                                </span>
                            </div>
                            {!! Form::file('avatar', ['id' => 'hidden', 'accept' => 'image/*', 'class' => 'user_profile_pic']) !!}
                        </div>
                        <div class="mb-4">
                            {!! Form::label('name', 'Name', ['class' => 'form-label', 'for' => 'example-text-input']) !!}
                            <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                id="example-text-input-invalid" placeholder="Name Input" name="name"
                                value="{{ $user->name }}">
                            <div class="invalid-feedback">{{ $errors->has('name') ? '' . $errors->first('name') . '' : '' }}
                            </div>
                        </div>
                        <div class="mb-4">
                            {!! Form::label('email', 'Email', ['class' => 'form-label', 'for' => 'example-text-input']) !!}
                            <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                id="example-text-input-invalid" placeholder="Email Input" name="email"
                                value="{{ $user->email }}">
                            <div class="invalid-feedback">
                                {{ $errors->has('email') ? '' . $errors->first('email') . '' : '' }}</div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <div class="col-sm-8 col-sm-offset-8 mb-5">
                                    <button class="btn btn-w-m btn btn-primary" type="submit">{{ __('Update') }}</button>
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="btn btn-w-m btn btn-danger">{{ __('Cancel') }}</a>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">{{ __('Change Password') }}</h3>
                    </div>
                    <div class="block-content">
                        {!! Form::open(['route' => 'admin.updatePassword', 'files' => true]) !!}
                        <div class="mb-4">
                            {!! Form::label('old_password', 'Old Password', ['class' => 'form-label', 'for' => 'example-text-input']) !!}
                            <input type="password"
                                class="form-control {{ $errors->has('old_password') ? 'is-invalid' : '' }}"
                                id="example-text-input-invalid" placeholder="Current Password Input" name="old_password"
                                value="{{ old('old_password') }}">
                            <div class="invalid-feedback">
                                {{ $errors->has('old_password') ? '' . $errors->first('old_password') . '' : '' }}</div>
                        </div>
                        <div class="mb-4">
                            {!! Form::label('new_password', 'New Password', ['class' => 'form-label', 'for' => 'example-text-input']) !!}
                            <input type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                id="example-text-input-invalid" placeholder="New Password Input" name="password">
                            <div class="invalid-feedback">
                                {{ $errors->has('password') ? '' . $errors->first('password') . '' : '' }}</div>
                        </div>
                        <div class="mb-4">
                            {!! Form::label('confirm_password', 'Confirm Password', [
                                'class' => 'form-label',
                                'for' => 'example-text-input',
                            ]) !!}
                            <input type="password"
                                class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                                id="example-text-input-invalid" placeholder="Confirm Password Input"
                                name="password_confirmation">
                            <div class="invalid-feedback">
                                {{ $errors->has('password_confirmation') ? '' . $errors->first('password_confirmation') . '' : '' }}
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <div class="col-sm-8 col-sm-offset-8 mb-5">
                                    <button class="btn btn-w-m btn btn-primary" type="submit">{{ __('Update') }}</button>
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="btn btn-w-m btn btn-danger">{{ __('Cancel') }}</a>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('styles')
    <style>
        #imagePreview {
            width: 100%;
            height: 100%;
            text-align: center;
            margin: 0 auto;
            position: relative;
        }

        #hidden {
            display: none !important;
        }

        #imagePreview img {
            height: 150px;
            width: 150px;
            border: 3px solid rgba(0, 0, 0, 0.4);
            padding: 3px;
            border-radius: 100%;
        }

        #imagePreview i {
            position: absolute;
            right: -18px;
            background: rgba(0, 0, 0, 0.5);
            padding: 5px;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            color: #fff;
            font-size: 18px;
        }
    </style>
@endsection
@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(".user_profile_pic").change(function() {
            var val = $(this).val();
            switch (val.substring(val.lastIndexOf('.') + 1).toLowerCase()) {
                case 'gif':
                case 'jpg':
                case 'png':
                case 'jpeg':
                    break;
                default:
                    $(this).val('');
                    alert("not an image");
                    break;
            }
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview img').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $('#imagePreview img').on('click', function() {
            $('input[type="file"]').trigger('click');
            $('input[type="file"]').change(function() {
                readURL(this);
            });
        });
    </script>
@endsection
