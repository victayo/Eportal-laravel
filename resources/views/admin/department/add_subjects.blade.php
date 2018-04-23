@extends('admin.admin')
@section('title', 'Department - Add Subjects')
@section('page-title', 'Add Subjects')
@section('content')
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="x-panel">
                <div class="x-title">
                    <h2>Add Subjects</h2>
                </div>
                <div class="x-content">
                    @if($subjects->count())
                    <form method="POST" action=" {{route('admin.department.addSubject', ['school' => $school->getId(), 'class' => $class->getId(), 'department' => $department->getId()])}}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            @foreach($subjects as $subject)
                                <div>
                                    <input type="checkbox" name="subjects[]" value="{{ $subject->getId() }}"> {{ $subject->getName() }}
                                </div>
                            @endforeach
                        </div>
                        <button class="btn btn-primary">Add Subjects</button>
                    </form>
                        @else
                        <div class="well">
                            <p>No Subjects available to add to this department</p>
                            <div>
                                <a class="btn btn-primary" href="{{ route('admin.department.subjects', ['school' => $school->getId(), 'class' => $class->getId(), 'department' => $department->getId()]) }}">Back</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection