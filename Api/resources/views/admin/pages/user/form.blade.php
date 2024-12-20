<div class="row push">
    <div class="col-lg-12 col-xl-12">
        <div class="mb-4">
            <div id="imagePreview" class="profile-image">
                <center>
                    @if (!empty($user->avatar))
                        <img src="{!! @$user->avatar !== '' ? url('storage/user/' . @$user->avatar) : url('storage/user/user.png') !!}" alt="user-img" class="img-circle">
                    @else
                        <img src="{!! url('storage/user/user.png') !!}" alt="user-img" class="img-circle" accept="image/*">
                    @endif
                </center>
            </div>
            {!! Form::file('avatar', ['id' => 'hidden', 'accept' => 'image/*']) !!}
        </div>
        <div class="mb-4">
            {!! Form::label('name', 'Name', ['class' => 'form-label', 'for' => 'example-text-input']) !!}
            {!! Form::text('name', null, [
                'class' => 'form-control ' . ($errors->has('name') ? 'is-invalid' : ''),
                'id' => 'example-text-input-invalid',
                'placeholder' => 'Name Input',
            ]) !!}
            <div class="invalid-feedback">{{ $errors->has('name') ? '' . $errors->first('name') . '' : '' }}</div>
        </div>
        <div class="mb-4">
            {!! Form::label('email', 'Email', ['class' => 'form-label', 'for' => 'example-text-input']) !!}
            {!! Form::text('email', null, [
                'class' => 'form-control ' . ($errors->has('email') ? 'is-invalid' : ''),
                'id' => 'example-text-input-invalid',
                'placeholder' => 'Email Input',
            ]) !!}
            <div class="invalid-feedback">{{ $errors->has('email') ? '' . $errors->first('email') . '' : '' }}</div>
        </div>
        @if (empty($user->password))
            <div class="mb-4">
                {!! Form::label('password', 'Password', ['class' => 'form-label', 'for' => 'example-text-input']) !!}
                {!! Form::text('password', null, [
                    'class' => 'form-control ' . ($errors->has('password') ? 'is-invalid' : ''),
                    'id' => 'example-text-input-invalid',
                    'placeholder' => 'Password Input',
                ]) !!}
                <div class="invalid-feedback">{{ $errors->has('password') ? '' . $errors->first('password') . '' : '' }}
                </div>
            </div>
            <div class="mb-4">
                {!! Form::label('password_confirmation', 'Confirm Password', [
                    'class' => 'form-label',
                    'for' => 'example-text-input',
                ]) !!}
                {!! Form::text('password_confirmation', null, [
                    'class' => 'form-control ' . ($errors->has('password_confirmation') ? 'is-invalid' : ''),
                    'id' => 'example-text-input-invalid',
                    'placeholder' => 'Confirm Password Input',
                ]) !!}
                <div class="invalid-feedback">
                    {{ $errors->has('password_confirmation') ? '' . $errors->first('password_confirmation') . '' : '' }}
                </div>
            </div>
        @endif
    </div>
</div>
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
