@extends('admin.admin')
@section('title', 'Edit Term')
@section('page-title', 'Edit Term')
@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <h4>Edit Term</h4>
        </div>
        <div class="col-md-12 col-xs-12 m-2">
            @include('admin.partials._form', ['action' => route('admin.term.edit', ['term' => $term->getId()]), 'name' => $term->getName()])
        </div>
    </div>
@endsection