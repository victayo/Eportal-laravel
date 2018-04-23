@extends('admin.admin')
@section('title', 'Edit School')
@section('page-title', 'Edit School')
@section('content')
    <div class="row">
        <div class="col-md-12 col-xs-12">
            @include('admin.partials._form', ['action' => route('admin.school.edit', ['school' => $school->getId()]), 'name' => $school->getName()])
        </div>
    </div>
@endsection