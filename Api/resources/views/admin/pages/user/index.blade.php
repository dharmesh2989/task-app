@extends('admin.layouts.app')
@section('title')
    Users Management
@endsection
@section('mainContent')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-2">
                        {{ __('Users DataTables') }}
                    </h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">
                        {{ __('Users Tables transformed with dynamic features.') }}
                    </h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            {{ __('Users DataTables') }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">{{ __('Users Table') }} <small>{{ __('Export Buttons') }}</small></h3>
                <a href="{{ route('admin.user.create') }}" class="btn btn-w-m btn btn-primary">{{ __('Add Users') }}</a>
            </div>
            <div class="block-content block-content-full">
                <table class="table table-bordered table-striped table-vcenter js-dataTable-buttons">
                    <thead>
                        <tr>
                            <th class="text-center">{{ __('#') }}</th>
                            <th>{{ __('Avatar') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th class="d-none d-sm-table-cell" style="width: 30%;">{{ __('Email') }}</th>
                            <th class="d-none d-sm-table-cell" style="width: 15%;">{{ __('User Type') }}</th>
                            <th class="d-none d-sm-table-cell" style="width: 15%;">{{ __('Status') }}</th>
                            <th class="notexport">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- PopUp Model --}}
    <div class="modal fade" id="modal-block-fadein" tabindex="-1" role="dialog" aria-labelledby="modal-block-fadein"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-transparent mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">{{ __('Users Detail') }}</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content fs-sm testdata">
                    </div>
                    <div class="block-content block-content-full text-end bg-body">
                        <button type="button" class="btn btn-sm btn-danger me-1"
                            data-bs-dismiss="modal">{{ __('Close') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet"
        href="{{ asset('assets/admin/assets/js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/admin/assets/js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/admin/assets/js/plugins/datatables-responsive-bs5/css/responsive.bootstrap5.min.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css">

    <style>
        .btn-primary {
            --bs-btn-color: #fff !important;
            --bs-btn-bg: #4c78dd !important;
            --bs-btn-border-color: #4c78dd !important;
            --bs-btn-hover-color: #fff !important;
            --bs-btn-hover-bg: #3d60b1 !important;
            --bs-btn-hover-border-color: #395aa6 !important;
            --bs-btn-focus-shadow-rgb: 103, 140, 226 !important;
            --bs-btn-active-color: #fff !important;
            --bs-btn-active-bg: #3d60b1 !important;
            --bs-btn-active-border-color: #395aa6 !important;
            --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125) !important;
            --bs-btn-disabled-color: #fff !important;
            --bs-btn-disabled-bg: #4c78dd !important;
            --bs-btn-disabled-border-color: #4c78dd !important;
        }
    </style>
@endsection
@section('scripts')
    <script src="{{ asset('assets/admin/assets/js/lib/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/admin/assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/admin/assets/js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/admin/assets/js/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}">
    </script>
    <script src="{{ asset('assets/admin/assets/js/plugins/datatables-responsive-bs5/js/responsive.bootstrap5.min.js') }}">
    </script>
    <script src="{{ asset('assets/admin/assets/js/plugins/datatables-buttons/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/admin/assets/js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js') }}">
    </script>
    <script src="{{ asset('assets/admin/assets/js/plugins/datatables-buttons-jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/admin/assets/js/plugins/datatables-buttons-pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/admin/assets/js/plugins/datatables-buttons-pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/admin/assets/js/plugins/datatables-buttons/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/admin/assets/js/plugins/datatables-buttons/buttons.html5.min.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script>

    <script type="text/javascript">
        $(function() {
            var table = $('.js-dataTable-buttons').DataTable({
                processing: true,
                serverSide: true,
                sWrapper: "dataTables_wrapper dt-bootstrap5",
                sFilterInput: "form-control form-control-sm",
                sLengthSelect: "form-select form-select-sm",
                language: {
                    lengthMenu: "_MENU_",
                    search: "_INPUT_",
                    searchPlaceholder: "Search..",
                    info: "Page <strong>_PAGE_</strong> of <strong>_PAGES_</strong>",
                    paginate: {
                        first: '<i class="fa fa-angle-double-left"></i>',
                        previous: '<i class="fa fa-angle-left"></i>',
                        next: '<i class="fa fa-angle-right"></i>',
                        last: '<i class="fa fa-angle-double-right"></i>'
                    }
                },
                dom: {
                    button: {
                        className: "btn btn-sm btn-primary"
                    }
                },
                ajax: {
                    url: "{{ route('admin.user.index') }}",
                    data: function(d) {
                        d.id = $('#id').val(),
                            d.name = $('#name').val(),
                            d.search = $('input[type="search"]').val()
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'id',
                    },
                    {
                        data: 'avatar',
                        name: 'avatar'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'user_type',
                        name: 'user_type'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                pageLength: 10,
                lengthMenu: [
                    [5, 10, 15, 20],
                    [5, 10, 15, 20]
                ],
                autoWidth: !1,
                responsive: !0,
                buttons: [{
                        extend: 'copy',
                        text: '<i class="fa fa-fw fa-copy me-1"></i>Copy',
                        className: 'btn btn-sm btn-primary buttons-copy buttons-html5',
                        charset: 'utf-8',
                        fieldSeparator: ',',
                        bom: true,
                        filename: 'Users_Copy',
                        exportOptions: {
                            columns: ':not(.notexport)'
                        },
                    },
                    {
                        extend: 'csv',
                        text: '<i class="fa fa-fw fa-file-csv me-1"></i>CSV',
                        className: 'btn btn-sm btn-primary buttons-csv buttons-html5',
                        charset: 'utf-8',
                        fieldSeparator: ',',
                        bom: true,
                        filename: 'Users_CSV',
                        exportOptions: {
                            columns: ':not(.notexport)'
                        },
                    },
                    {
                        extend: 'excel',
                        text: '<i class="fa fa-fw fa-file-excel me-1"></i>Excel',
                        className: 'btn btn-sm btn-primary buttons-excel buttons-html5',
                        charset: 'utf-8',
                        fieldSeparator: ',',
                        bom: true,
                        filename: 'Users_Excel',
                        exportOptions: {
                            columns: ':not(.notexport)'
                        },
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fa fa-fw fa-file-pdf me-1"></i>PDF',
                        className: 'btn btn-sm btn-primary buttons-pdf buttons-html5',
                        charset: 'utf-8',
                        fieldSeparator: ',',
                        bom: true,
                        filename: 'Users_PDF',
                        exportOptions: {
                            columns: ':not(.notexport)'
                        },
                    },
                    {
                        extend: 'print',
                        text: '<i class="fa fa-fw fa-print me-1"></i>Print',
                        className: 'btn btn-sm btn-primary buttons-print',
                        charset: 'utf-8',
                        fieldSeparator: ',',
                        bom: true,
                        filename: 'Users_Print',
                        exportOptions: {
                            columns: ':not(.notexport)'
                        },
                    }
                ],
                dom: "<'row'<'col-sm-12'<'text-center bg-body-light py-2 mb-2'B>>><'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"
            });
        });

        $(document).on("click", "a.deleteUser", function(e) {
            var row = $(this);
            var id = $(this).attr('data-id');
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this record",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#e69a2a",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel please!",
                closeOnConfirm: false,
                closeOnCancel: false
            }, function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: "{{ route('admin.user.delete', ['']) }}" + "/" + id,
                        type: 'post',
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(msg) {
                            if (msg.status == 'success') {
                                swal({
                                        title: "Deleted",
                                        text: "Delete Record success",
                                        type: "success"
                                    },
                                    function() {
                                        location.reload();
                                    });
                            } else {
                                swal("Warning!", msg.message, "warning");
                            }
                        },
                        error: function() {
                            swal("Error!", 'Error in delete Record', "error");
                        }
                    });
                } else {
                    swal("Cancelled", "Your Users is safe :)", "error");
                }
            });
            return false;
        })

        $(document).on("click", "a.viewUser", function(e) {
            var row = $(this);
            var id = $(this).attr('data-id');
            $.ajax({
                url: "{{ route('admin.user.show') }}",
                type: 'get',
                data: {
                    id: id
                },
                success: function(msg) {
                    $('.testdata').html(msg);
                    $('#modal-block-fadein').modal('show');
                },
                error: function() {
                    swal("Error!", 'Error in Record Not Show', "error");
                }
            });
        });

        $(document).on("click", "a.statusUser", function(e) {
            var row = $(this);
            var id = $(this).attr('data-id');
            swal({
                title: "Are you sure?",
                text: "You want's to update this record status ",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#e69a2a",
                confirmButtonText: "Yes, updated it!",
                cancelButtonText: "No, cancel plx!",
                closeOnConfirm: false,
                closeOnCancel: false
            }, function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: "{{ route('admin.user.changeStatus', 'replaceid') }}",
                        type: 'post',
                        data: {
                            "_method": 'post',
                            'id': id,
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(msg) {
                            if (msg.status == 'success') {
                                swal({
                                        title: "Status",
                                        text: "Status Success Update",
                                        type: "success"
                                    },
                                    function() {
                                        location.reload();
                                    });
                            } else {
                                swal("Warning!", msg.message, "warning");
                            }
                        },
                        error: function() {
                            swal("Error!", 'Error in Status Record', "error");
                        }
                    });
                } else {
                    swal("Cancelled", "Your User Status is safe :)", "error");
                }
            });
            return false;
        })
    </script>
@endsection
