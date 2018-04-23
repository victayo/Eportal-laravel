@extends('admin.admin')
@section('title', 'School - Add Classes')
@section('page-title', 'Add Classes')
@section('content')
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="x-panel">
                <div class="x-title">
                    <h2>Add Classes</h2>
                </div>
                <div class="x-content">
                    <form method="POST" action=" {{route('admin.school.addClass', ['school' => $school->getId()])}}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            @foreach($classes as $class)
                                <div>
                                    <input type="checkbox" name="classes[]" value="{{ $class->getId() }}"> {{ $class->getName() }}
                                </div>
                            @endforeach
                        </div>
                        <button class="btn btn-primary">Add Classes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection