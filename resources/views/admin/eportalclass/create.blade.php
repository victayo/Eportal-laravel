@extends('admin.admin')
@section('title', 'Create Class')
@section('page-title', 'Create Class')
@section('content')
    <div class="row">
        <div class="col-md-12 col-xs-12">
            @include('admin.partials._form', ['action' => route('admin.class.create')])
        </div>
    </div>
@endsection