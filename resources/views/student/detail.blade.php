@extends('master')

@section('title')
    Student
@endsection

@section('customcss')
    
@endsection

@section('customjs')
    
@endsection

@section('main')
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
        <div class="widget-content widget-content-area br-4">
            <img src="https://github.com/favjiw/student-faces/blob/main/MUHAMMAD%20FAVIAN%20JIWANI.jpg" alt="{{ $record["name"] }}" srcset="">
            <div class="row">
                <p>Nama :</p>
                <p class="ml-2">  {{ $record["name"] }}</p>
            </div>
            <div class="row">
                <p>Kelas :</p>
                <p class="ml-2">  {{ $record["class_id"] }}</p>
            </div>
            <div class="row">
                <p>Email :</p>
                <p class="ml-2">  {{ $record["email"] }}</p>
            </div>
            <div class="row">
                <p>No Telepon :</p>
                <p class="ml-2">  {{ $record["telp"] }}</p>
            </div>
        </div>
        <div class="widget-content widget-content-area br-4 ml-2">
            
        </div>
    </div>
</div>
@endsection