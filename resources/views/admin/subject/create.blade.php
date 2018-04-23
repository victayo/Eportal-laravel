@extends('admin.admin')
@section('title', 'Create Subject')
@section('page-title', 'Create Subject')
@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <h4>New Subject</h4>
        </div>
        <div class="col-md-6 col-xs-12 m-2">
            @include('admin.partials._form', ['action' => route('admin.subject.create')])
        </div>
    </div>
@endsection