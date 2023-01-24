@extends('master')
@section('title')

@endsection

@section('customcss')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('plugins/table/datatable/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('plugins/table/datatable/dt-global_style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/forms/theme-checkbox-radio.css') }}">
    <link href="{{ URL::asset('assets/css/apps/invoice-list.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('customjs')
<script src={{ URL::asset('assets/js/scrollspyNav.js')}}></script>
<script src={{ URL::asset('plugins/apex/apexcharts.min.js')}}></script>
<script src={{ URL::asset('plugins/apex/custom-apexcharts.js')}}></script>
<script src={{ URL::asset('plugins/table/datatable/datatables.js')}}></script>
<script>        
    $('#default-ordering').DataTable( {
        "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
    "<'table-responsive'tr>" +
    "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
        "oLanguage": {
            "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
            "sInfo": "Showing page _PAGE_ of _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Search...",
           "sLengthMenu": "Results :  _MENU_",
        },
        "order": [[ 3, "desc" ]],
        "stripeClasses": [],
        "lengthMenu": [7, 10, 20, 50],
        "pageLength": 7,
        drawCallback: function () { $('.dataTables_paginate > .pagination').addClass(' pagination-style-13 pagination-bordered mb-5'); }
    } );
</script>
@endsection

@section('main')
<div class="layout-px-spacing">
    <div class="page-header">
        <nav class="breadcrumb-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">{{time()}}</a></li>
            </ol>
        </nav>
    </div>
    <div class="row layout-top-spacing" style="transform: scale(0.9)">
        <div class="widget-content widget-content-area br-6" style="width: 100%;">
            <form action="{{ route("student.insert") }}" class="p-5" method="POST">
                @csrf
                <h3 class="ml-3"></h3>
                <p class="ml-3">Student ID</p>
                <input type="text" name="student_id" id="" class="form-control m-3" value="" placeholder="Student ID here">
                <p class="ml-3">Name</p>
                <input type="text" name="name" id="" class="form-control m-3" value="" placeholder="Name here">
                <p class="ml-3">Class ID</p>
                <input type="number" name="class_id" id="" class="form-control m-3" value="" min=1 max=8 placeholder="Class ID here">
                <p class="ml-3">Email</p>
                <input type="email" name="email" id="" class="form-control m-3" value="" placeholder="Email here">
                <p class="ml-3">Telp</p>
                <input type="text" name="telp" id="" class="form-control m-3" value="" placeholder="Telp here">
                
                <button class="btn btn-outline-success ml-3 mt-3"> <i class="fas fa-save mr-2"></i> Tambahkan </button>
            </form>
        </div>
    </div>
@endsection