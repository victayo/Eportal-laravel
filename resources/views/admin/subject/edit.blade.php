@extends('admin.admin')
@section('title', 'Edit Subject')
@section('page-title', 'Edit Subject')
@section('content')
    <div class="row">
        <div class="col-md-12 col-xs-12">
            @include('admin.partials._form', ['action' => route('admin.subject.edit', ['subject' => $subject->getId()]), 'name' => $subject->getName()])
        </div>
    </div>
@endsection