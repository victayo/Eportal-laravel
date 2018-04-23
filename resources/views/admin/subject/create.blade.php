@extends('admin.admin')
@section('title', 'Create Subject')
@section('page-title', 'Create Subject')
@section('content')
    <div class="row">
        <div class="col-md-12 col-xs-12">
            @include('admin.partials._form', ['action' => route('admin.subject.create')])
        </div>
    </div>
@endsection