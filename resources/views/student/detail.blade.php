@extends('master')

@section('title')
    Student
@endsection

@section('customcss')

@endsection

@section('customjs')
<script src={{ URL::asset('plugins/apex/apexcharts.min.js')}}></script>
<script src={{ URL::asset('plugins/apex/custom-apexcharts.js')}}></script>
@endsection

@section('main')
<div class="d-none">
    <p id="hadir">{{ $value["hadir"] }}</p>
    <p id="sakit">{{ $value["sakit"] }}</p>
    <p id="izin">{{ $value["izin"] }}</p>
</div>
<div class="layout-px-spacing">
    <div class="page-header">
        <nav class="breadcrumb-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Student</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0);">Detail</a></li>
            </ol>
        </nav>
    </div>
    <div class="row layout-top-spacing" id="cancel-row">
        <div class="widget-content widget-content-area statbox widget box box-shadow br-4 col-xl-6">
            <div class="text-left user-info">
                <img class="br-4 ml-2" src="https://favjiw.github.io/student-faces/{{$record["name"]}}.jpg" alt="{{ $record["name"] }}" srcset="" style="width:100px;">
            </div>
            <div class="row mt-4 ml-2">
                <p>Nama :</p>
                <p class="ml-2">  {{ $record["name"] }}</p>
            </div>
            <div class="row ml-2">
                <p>Kelas :</p>
                <p class="ml-2">  {{ $record["class_id"] }}</p>
            </div>
            <div class="row ml-2">
                <p>Email :</p>
                <p class="ml-2">  {{ $record["email"] }}</p>
            </div>
            <div class="row ml-2">
                <p>No Telepon :</p>
                <p class="ml-2">  {{ $record["telp"] }}</p>
            </div>
        </div>
        <div id="chartRadial" class="col-xl-6 layout-spacing">
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