@extends('admin.admin')
@section('title', 'Class - Add Departments')
@section('page-title', 'Add Departments')
@section('content')
    <div class="card mb-3">
        <div class="card-header">
            Select Departments
        </div>
        @if($departments->count())
            <form method="POST" action=" {{route('admin.class.addDepartment', ['school' => $school->getId(), 'class' => $class->getId()])}}">
                {{ csrf_field() }}
                <ul class="list-group list-group-flush">
                    @foreach($departments as $department)
                        <li class="list-group-item">
                            <input type="checkbox" name="departments[]" value="{{ $department->getId() }}"> {{ $department->getName() }}
                        </li>
                    @endforeach
                </ul>
                <button class="btn btn-primary m-3">Add Departments</button>
            </form>
        @else
            <div class="card-body text-center">
                <p class="card-text">No Departments available to add to this class</p>
                <div>
                    <a class="btn btn-primary" href="{{ route('admin.class.departments', ['school' => $school->getId(), 'class' => $class->getId()]) }}">Back</a>
                </div>
            </div>
        @endif
    </div>
@endsection