@extends('admin.admin')
@section('title', 'Subjects')
@section('page-title', 'Subjects')
@section('content')
<form action="{{ route('admin.user.register', ['type' => $type]) }}" method="POST" ng-controller="RegisterController">
    {{ csrf_field() }}
    @include('admin.partials.register_user_form')
    @include('admin.partials.property_form')
    <input type="submit" value="Register" class="btn btn-primary mb-3">
</form>
@endsection