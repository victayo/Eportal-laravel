@extends('admin.admin')
@section('title', 'School - Add Classes')
@section('page-title', 'Add Classes')
@section('content')
    <div class="card mb-3">
        <div class="card-header">
            Select Classes
        </div>
        @if($classes->count())
        <form method="POST" action=" {{route('admin.school.addClass', ['school' => $school->getId()])}}">
            {{ csrf_field() }}
            <ul class="list-group list-group-flush">
                @foreach($classes as $class)
                    <li class="list-group-item">
                        <input type="checkbox" name="classes[]" value="{{ $class->getId() }}"> {{ $class->getName() }}
                    </li>
                @endforeach
            </ul>
            <button class="btn btn-primary m-3">Add Classes</button>
        </form>
            @else
            <div class="card-body text-center">
                <p class="card-text">No Classes available to add to school</p>
                <a href="{{ route('admin.school.classes') }}" class="btn btn-primary">Back</a>
            </div>
        @endif
    </div>
@endsection