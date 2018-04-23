@extends('admin.admin')
@section('title', 'Edit Subject')
@section('page-title', 'Edit Subject')
@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <h4>Edit Subject</h4>
        </div>
        <div class="col-md-12 col-xs-12 m-2">
            @include('admin.partials._form', ['action' => route('admin.subject.edit', ['subject' => $subject->getId()]), 'name' => $subject->getName()])
        </div>
    </div>
@endsection