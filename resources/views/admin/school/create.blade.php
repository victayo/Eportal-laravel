@extends('admin.admin')
@section('title', 'Create School')
@section('page-title', 'Create School')
@section('content')
    <div class="row">
        <div class="col-md-12 col-xs-12">
            @include('admin.school._form', ['action' => route('admin.school.create')])
        </div>
    </div>
@endsection