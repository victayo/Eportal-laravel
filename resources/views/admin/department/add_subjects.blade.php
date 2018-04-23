@extends('admin.admin')
@section('title', 'Department - Add Subjects')
@section('page-title', 'Add Subjects')
@section('content')
    <div class="card mb-3">
        <div class="card-header">
            Select Subjects
        </div>
        @if($subjects->count())
            <form method="POST" action=" {{route('admin.department.addSubject', ['school' => $school->getId(), 'class' => $class->getId(), 'department' => $department->getId()])}}">
                {{ csrf_field() }}
                <ul class="list-group list-group-flush">
                    @foreach($subjects as $subject)
                        <li class="list-group-item">
                            <input type="checkbox" name="subjects[]" value="{{ $subject->getId() }}"> {{ $subject->getName() }}
                        </li>
                    @endforeach
                </ul>
                <button class="btn btn-primary m-3">Add Subjects</button>
            </form>
        @else
            <div class="card-body text-center">
                <p class="card-text">No Subjects available to add to this department</p>
                <div>
                    <a class="btn btn-primary" href="{{ route('admin.department.subjects', ['school' => $school->getId(), 'class' => $class->getId(), 'department' => $department->getId()]) }}">Back</a>
                </div>
            </div>
        @endif
    </div>
@endsection