@extends('admin.admin')
@section('title', 'Edit Department')
@section('page-title', 'Edit Department')
@section('content')
    <div class="row">
        <div class="col-md-12 col-xs-12">
            @include('admin.partials._form', ['action' => route('admin.department.edit', ['department' => $department->getId()]), 'name' => $department->getName()])
        </div>
    </div>
@endsection