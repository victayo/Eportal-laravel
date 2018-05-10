@extends('admin.admin')
@section('title', 'Create '.$property_name)
@section('page-title', 'Create '.ucwords($property_name))
@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <h4 class="text-capitalize">New {{ $property_name }}</h4>
        </div>
        <div class="col-md-6 col-xs-12 m-2">
            @include('admin.partials._form', ['action' => $create_link])
        </div>
    </div>
@endsection