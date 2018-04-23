@extends('admin.admin')
@section('title', 'Edit Class')
@section('page-title', 'Edit Class')
@section('content')
    <div class="row">
        <div class="col-md-12 col-xs-12">
            @include('admin.partials._form', ['action' => route('admin.class.edit', ['class' => $class->getId()]), 'name' => $class->getName()])
        </div>
    </div>
@endsection