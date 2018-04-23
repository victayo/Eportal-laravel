@extends('admin.admin')
@section('title', 'Edit Class')
@section('page-title', 'Edit Class')
@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Edit Class</h4>
        </div>
        <div class="col-md-6 col-xs-12 m-2">
            @include('admin.partials._form', ['action' => route('admin.class.edit', ['class' => $class->getId()]), 'name' => $class->getName()])
        </div>
    </div>
@endsection