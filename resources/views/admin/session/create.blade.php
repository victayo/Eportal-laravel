@extends('admin.admin')
@section('title', 'Create Session')
@section('page-title', 'Create Session')
@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <h4>New Session</h4>
        </div>
        <div class="col-md-6 col-xs-12 m-2">
            @include('admin.partials._form', ['action' => route('admin.session.create')])
        </div>
    </div>
@endsection