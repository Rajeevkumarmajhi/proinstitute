@extends('layouts.admin')
@section('title', 'Teacher')

@section('styles')
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- sweet alert framework -->
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/sweetalert/dist/sweetalert.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.css') }}" />
    <style type="text/css">
        .order_status {
            cursor: pointer;
        }

        .hide {
            display: none;
        }

        .alignright>.dt-buttons {
            float: right;
        }

        #orders_length>label {
            float: left;
        }

        #vendor_id {
            margin-left: 10px;
        }

        .badge-danger {
            background-color: red;
        }

        .badge-success {
            background-color: green;
        }

        .badge-primary {
            background-color: blue;
        }

        .badge-warning {
            background-color: #2f2f0f;
        }

        div.dataTables_wrapper div.dataTables_filter input {
            margin-right: 5px;
            height: 40px;
        }
    </style>
@endsection

@section('content')

    <div class="content-wrapper" style="min-height: 1302.4px;">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Teachers</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Teachers</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Teachers</h3>
                                <a href="{{ route('teacher.create') }}" class="btn btn-primary float-right">Create Teacher</a>
                            </div>

                            <div class="card-body">
                                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                
                                    <div class="row">
                                        <div class="col-sm-12 table-responsive">
                                            <table id="serverTable" class="table table-hover text-nowrap">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Name</th>
                                                        <th>Address</th>
                                                        <th>Gender</th>
                                                        <th>Status</th>
                                                        <th>Created At</th>
                                                        <th style="min-width:120px!important;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>

    </div>

    <span id="totalDataCount" data-total="{{ $dataCount }}"></span>
    <input type="hidden" id="ajaxroute" name="ajaxroute" value="{{ route('teacher.ajaxTable') }}" />

@endsection

@section('scripts')
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-fixedcolumns/js/fixedColumns.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>

    <script src="{{ asset('plugins/datatable_buttons/buttons.bootstrap.min.js') }}"></script>
    <script src="{{ asset('plugins/datatable_buttons/vfs_fonts.js') }}"></script>
    <script src="{{ asset('plugins/datatable_buttons/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatable_buttons/buttons.print.min.js') }}"></script>
    <script src="{{ asset('plugins/datatable_buttons/jszip.min.js') }}"></script>

    <script src="{{ asset('bower_components/moment/moment.js') }}"></script>
    <script type="text/javascript" src="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.js') }}">
    </script>
    <!-- sweet alert js -->
    <script type="text/javascript" src="{{ asset('bower_components/sweetalert/dist/sweetalert.min.js') }}"></script>

    <script type="text/javascript">
        $(function() {

            const table_name = 'serverTable';
            const data_url = $('#ajaxroute').val();
            const columns = [{
                    "data": "id"
                },
                {
                    "data": "name"
                },
                {
                    "data": "address"
                },
                {
                    "data": "gender"
                },
                {
                    "data": "status"
                },
                {
                    "data": "created_at"
                },
                {
                    "data": "action"
                },
            ];

            function initializeDTR(t, a, n, e = 0, o = 10, l, i) {
                $("#" + t).DataTable({
                    processing: !0,
                    serverSide: !0,
                    displayStart: e,
                    pageLength: o,
                    paging: !0,
                    ajax: {
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                        },
                        url: n,
                        data: l,
                        dataType: "json",
                        type: "POST"
                    },
                    columns: a,
                    dom: "<'row'<'col-sm-6 alignleft'l><'col-sm-6 alignright'Bf>><'row'<'col-sm-12't>><'row'<'col-sm-12'ip>>",
                    buttons: [{
                        extend: "pdfHtml5",
                        title: i,
                        exportOptions: {
                            columns: ":not(:last-child)"
                        },
                        footer: !0,
                        action: function(t, a, n, e) {
                            s(t, a, n, e)
                        }
                    }, {
                        extend: "excelHtml5",
                        title: i,
                        exportOptions: {
                            columns: ":not(:last-child)"
                        },
                        footer: !0,
                        action: function(t, a, n, e) {
                            s(t, a, n, e)
                        }
                    }, {
                        extend: "print",
                        title: i,
                        exportOptions: {
                            columns: ":not(:last-child)"
                        },
                        footer: !0,
                        action: function(t, a, n, e) {
                            s(t, a, n, e)
                        }
                    }]
                }).buttons().container().appendTo("#reportsexports");
                var s = function(t, a, n, e) {
                    var o = this,
                        l = a.settings()[0]._iDisplayStart;
                    a.one("preXhr", function(t, i, s) {
                        s.start = 0, s.length = $("#totalDataCount").data("total"), a.one("preDraw",
                            function(t, i) {
                                return function(t, a, n, e, o) {
                                    e[0].className.indexOf("buttons-excel") >= 0 ? $.fn
                                        .dataTable.ext.buttons.excelHtml5.available(n, o) ? $.fn
                                        .dataTable.ext.buttons.excelHtml5.action.call(t, a, n,
                                            e, o) : $.fn.dataTable.ext.buttons.excelFlash.action
                                        .call(t, a, n, e, o) : e[0].className.indexOf(
                                            "buttons-pdf") >= 0 ? $.fn.dataTable.ext.buttons
                                        .pdfHtml5.available(n, o) ? $.fn.dataTable.ext.buttons
                                        .pdfHtml5.action.call(t, a, n, e, o) : $.fn.dataTable
                                        .ext.buttons.pdfFlash.action.call(t, a, n, e, o) : e[0]
                                        .className.indexOf("buttons-print") >= 0 && $.fn
                                        .dataTable.ext.buttons.print.action(a, n, e, o)
                                }(o, t, a, n, e), a.one("preXhr", function(t, a, n) {
                                    i._iDisplayStart = l, n.start = l
                                }), setTimeout(a.ajax.reload, 0), !1
                            })
                    }), a.ajax.reload()
                }
            }

            let data = {};

            initializeDTR(table_name, columns, data_url, start = 0, length = 10, data, 'Service Men Report');

            $(document).on('click', '.rowDelete', function() {
                let id = $(this).data('id');
                let url = $(this).data('link');
                swal({
                        title: "Are you sure?",
                        text: "You will not be able to recover this imaginary file!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes, delete it!",
                        cancelButtonText: "No, cancel plx!",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                url: url,
                                type: "DELETE",
                                data: {
                                    "id": id
                                },
                                beforeSend: function() {
                                    console.log('ajax fired');
                                },
                                success: function(data) {
                                    swal("Deleted!",
                                        "Your imaginary file has been deleted.",
                                        "success");
                                    location.reload();
                                },
                                error: function(xhr) {
                                    console.log(xhr);
                                }
                            });
                        } else {
                            swal("Cancelled", "Your imaginary file is safe :)", "error");
                        }
                    });
            });

        });
    </script>
@endsection
