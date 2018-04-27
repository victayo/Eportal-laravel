@extends('admin.admin')
@section('title', 'Edit School')
@section('page-title', 'Edit School')
@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <h4>Edit School</h4>
        </div>
        <div class="col-md-6 col-xs-12 m-2">
            @include('admin.partials._form', ['action' => route('admin.school.edit', ['school' => $school->getId()]), 'name' => $school->getName()])
        </div>
    </div>
@endsection