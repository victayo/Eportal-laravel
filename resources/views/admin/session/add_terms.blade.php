@extends('admin.admin')
@section('title', 'Session - Add Terms')
@section('page-title', 'Add Terms')
@section('content')
    <div class="card mb-3">
        <div class="card-header">
            Select Terms
        </div>
        @if($terms->count())
        <form method="POST" action=" {{route('admin.session.addTerm', ['session' => $session->getId()])}}">
            {{ csrf_field() }}
            <ul class="list-group list-group-flush">
                @foreach($terms as $term)
                    <li class="list-group-item">
                        <input type="checkbox" name="terms[]" value="{{ $term->getId() }}"> {{ $term->getName() }}
                    </li>
                @endforeach
            </ul>
            <button class="btn btn-primary m-3">Add Terms</button>
        </form>
            @else
            <div class="card-body text-center">
                <p class="card-text">No Terms available to add to session</p>
                <a href="{{ route('admin.session.terms') }}" class="btn btn-primary">Back</a>
            </div>
        @endif
    </div>
@endsection