@extends('admin.admin')
@section('title', 'Create Department')
@section('page-title', 'Create Department')
@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <h4>New Department</h4>
        </div>
        <div class="col-md-6 col-xs-12 m-2">
            @include('admin.partials._form', ['action' => route('admin.department.create')])
        </div>
    </div>
@endsection