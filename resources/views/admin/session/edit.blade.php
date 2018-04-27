@extends('admin.admin')
@section('title', 'Edit Session')
@section('page-title', 'Edit Session')
@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <h4>Edit Session</h4>
        </div>
        <div class="col-md-6 col-xs-12 m-2">
            @include('admin.partials._form', ['action' => route('admin.session.edit', ['session' => $session->getId()]), 'name' => $session->getName()])
        </div>
    </div>
@endsection