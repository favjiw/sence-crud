@extends('master')
@section('title')
    Dashboard
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
<div class="d-none">
    <p id="hadir">{{$data["hadir"]}}</p>
    <p id="sakit">{{$data["sakit"]}}</p>
    <p id="izin">{{$data["izin"]}}</p>
</div>
<div class="layout-px-spacing">
    <div class="page-header">
        <nav class="breadcrumb-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">{{$today}}</a></li>
            </ol>
        </nav>
    </div>
    <div class="row layout-top-spacing">
        <div class="widget-content widget-content-area br-6">
            <a href="{{ route("presence.pending") }}" class="btn btn-primary m-2 ">Pending </a>
            <table id="default-ordering" class="table table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>NIS</th>
                        <th>Status</th>
                        <th>Waktu Presensi Masuk</th>
                        <th>Waktu Presensi Keluar</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
`                    @foreach($value as $key => $val)
                    <tr>
                        <td>{{ $val["student_id"] }}</td>
                        <td><span>
                            @if($val["status"] == 3 || $val["status"] == 5)
                            Sakit
                            @elseif($val["status"] == 4 || $val["status"] == 6)
                            Izin
                            @elseif($val["status"] == 7 || $val["status"] == 8)
                            Terlambat
                            @else
                            Hadir
                            @endif     
                        </span> </td>
                        <td>{{ $val["time_in"] }}</td>
                        <td>{{ $val["time_out"] }}</td>
                        <td class="d-flex">
                            <a href="{{url('presence/'.$key)}}" class="btn btn-outline-dark"><i class="fas fa-eye"></i></a>
                            @if(null !== Session::get("admin"))
                            <form action="{{ route("presence.delete", $key) }}" method="POST">
                                @csrf
                                <button class="btn btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                            @endif
                            
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
            <div id="chartRadial" class="col-xl-4 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header">                                
                        <h4>Presentase Kehadiran Siswa Keseluruhan</h4>
                    </div>
                    <div class="widget-content widget-content-area">
                        <div id="radial-chart" class=""></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection