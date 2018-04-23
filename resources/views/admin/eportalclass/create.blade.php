@extends('admin.admin')
@section('title', 'Create Class')
@section('page-title', 'Create Class')
@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <h4>New Class</h4>
        </div>
        <div class="col-md-6 col-xs-12 m-2">
            @include('admin.partials._form', ['action' => route('admin.class.create')])
        </div>
    </div>
@endsection