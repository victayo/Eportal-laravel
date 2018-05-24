@extends('admin.admin')
@section('title', 'Subjects')
@section('page-title', 'Subjects')
@section('content')
    <form method="POST" ng-controller="RegisterController">
        {{ csrf_field() }}
        @include('admin.partials.register_user_form')
        @include('admin.partials.property_form', ['fields' => $fields])
        <input type="submit" value="Register" class="btn btn-primary mb-3" ng-click="submit()" ng-disabled="btn_disabled">
    </form>
@endsection