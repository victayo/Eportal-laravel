@extends('admin.admin')
@section('title', 'Edit '.$property_name)
@section('page-title', 'Edit '.ucwords($property_name))
@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <h4 class="text-capitalize">edit {{$property_name}}</h4>
        </div>
        <div class="col-md-6 col-xs-12 m-2">
            @include('admin.partials._form', ['action' => $edit_link, 'name' => $property->getName()])
        </div>
    </div>
@endsection