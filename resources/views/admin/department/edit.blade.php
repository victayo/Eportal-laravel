@extends('admin.admin_')
@section('title', 'Edit Department')
@section('page-title', 'Edit Department')
@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <h4>Edit Department</h4>
        </div>
        <div class="col-md-12 col-xs-12 m-2">
            @include('admin.partials._form', ['action' => route('admin.department.edit', ['department' => $department->getId()]), 'name' => $department->getName()])
        </div>
    </div>
@endsection