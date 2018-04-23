@extends('admin.admin')
@section('title', 'Class - Add Departments')
@section('page-title', 'Add Departments')
@section('content')
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="x-panel">
                <div class="x-title">
                    <h2>Add Departments</h2>
                </div>
                <div class="x-content">
                    @if($departments->count())
                    <form method="POST" action=" {{route('admin.class.addDepartment', ['school' => $school->getId(), 'class' => $class->getId()])}}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            @foreach($departments as $department)
                                <div>
                                    <input type="checkbox" name="departments[]" value="{{ $department->getId() }}"> {{ $department->getName() }}
                                </div>
                            @endforeach
                        </div>
                        <button class="btn btn-primary">Add Departments</button>
                    </form>
                        @else
                        <div class="well">
                            <p>No Departments available to add to this class</p>
                            <div>
                                <a class="btn btn-primary" href="{{ route('admin.class.departments', ['school' => $school->getId(), 'class' => $class->getId()]) }}">Back</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection