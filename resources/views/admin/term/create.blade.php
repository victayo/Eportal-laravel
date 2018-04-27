@extends('admin.admin')
@section('title', 'Create Term')
@section('page-title', 'Create Term')
@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <h4>New Term</h4>
        </div>
        <div class="col-md-6 col-xs-12 m-2">
            @include('admin.partials._form', ['action' => route('admin.term.create')])
        </div>
    </div>
@endsection