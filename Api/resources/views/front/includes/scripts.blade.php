<script src="{{ asset('assets/admin/assets/js/oneui.app.min.js') }}"></script>
{{-- <script src="{{ asset('assets/admin/assets/js/plugins/chart.js/chart.min.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/admin/assets/js/pages/be_pages_dashboard.min.js') }}"></script> --}}
<x-notify::notify />
@notifyJs
@yield('scripts')
