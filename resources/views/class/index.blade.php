@extends('master')

@section('title')
    Teacher
@endsection

@section('customcss')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('plugins/table/datatable/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('plugins/table/datatable/dt-global_style.css') }}">
@endsection

@section('customjs')
<script src={{ URL::asset('plugins/table/datatable/datatables.js')}}></script>
<script>
    $('#zero-config').DataTable({
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
        "stripeClasses": [],
        "lengthMenu": [7, 10, 20, 50],
        "pageLength": 7 
    });
</script>
@endsection

@section('main')
<div class="layout-px-spacing">
    <div class="page-header">
        <nav class="breadcrumb-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Class</a></li>
            </ol>
        </nav>
        <a href="{{route("class.create")}}" class="btn btn-primary">Tambah data</a>
    </div>
    <div class="row layout-top-spacing" id="cancel-row">
                
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <table id="zero-config" class="table dt-table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Grade</th>
                            <th>Field</th>
                            <th>Nama</th>
                            <th class="no-content dt-no-sorting">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($value as $key => $val)
                        <tr>
                            <td>{{ $val["id"] }}</td>
                            <td>{{ $val["grade"] }}</td>
                            <td>{{ $val["field"] }}</td>
                            <td>{{ $val["name"] }}</td>
                            <td class="d-flex">
                                <a href="{{url('class/'.$key)}}" class="btn btn-outline-dark"><i class="fas fa-eye"></i></a>
                                <form action="{{ route("class.delete", $key) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-outline-danger ml-2"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr> 
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Nama</th>
                            <th>NIS</th>
                            <th>Kelas</th>
                            <th></th>
                        </tr>   
                    </tfoot>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection