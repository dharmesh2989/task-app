<script src="{{ asset('assets/admin/assets/js/oneui.app.min.js') }}"></script>
<script src="{{ asset('assets/admin/assets/js/lib/jquery.min.js') }}"></script>
<script src="{{ asset('assets/admin/assets/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/admin/assets/js/pages/op_auth_signin.min.js') }}"></script>
<x-notify::notify />
@notifyJs
@yield('authScripts')
