@extends('admin.admin')
@section('title', 'Create School')
@section('page-title', 'Create School')
@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <h4>New School</h4>
        </div>
        <div class="col-md-6 col-xs-12 m-2">
            @include('admin.partials._form', ['action' => route('admin.school.create')])
        </div>
    </div>
@endsection