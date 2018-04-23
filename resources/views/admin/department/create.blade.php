@extends('admin.admin')
@section('title', 'Create Department')
@section('page-title', 'Create Department')
@section('content')
    <div class="row">
        <div class="col-md-12 col-xs-12">
            @include('admin.partials._form', ['action' => route('admin.department.create')])
        </div>
    </div>
@endsection