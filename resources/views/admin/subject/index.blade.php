@extends('admin.admin')
@section('title', 'Subjects')
@section('page-title', 'Subjects')
@section('content')
    <div class="card mb-3">
        <div class="card-header">
            Subjects
            <a href="{{ route('admin.subject.create') }}" class="btn btn-primary" style="float: right">Create New Subject</a>
        </div>
        @if($subjects->count())
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th><input type="checkbox"></th>
                        <th class="column-title property-column-title text-right">s/n</th>
                        <th class="column-title property-column-title text-right" style="display: table-cell; text-align: right">Name</th>
                        <th class="column-title property-column-title text-right" style="display: table-cell; text-align: right">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($subjects as $subject)
                        @if($loop->index % 2)
                            <tr class="even">
                        @else
                            <tr class="odd">
                                @endif
                                <td class="text-left"><input type="checkbox"></td>
                                <td class="property-column-data text-right">{{$loop->index + 1}}</td>
                                <td class="property-column-data text-right">{{ $subject->getName() }}</td>
                                <td class="property-column-data text-right">
                                    <a class="btn btn-primary" href="{{ route('admin.subject.edit', ['class' => $subject->getId()]) }}">Edit</a>
                                    <button class="btn btn-danger delete" data-subject="{{$subject->getId()}}">Delete</button>
                                </td>
                            </tr>
                            @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="card-body text-center">
                <p class="card-text">No registered subjects</p>
                <a class="btn btn-primary" href="{{ route('admin.subject.create') }}">Register Subject</a>
            </div>
        @endif
    </div>
@endsection
@push('scripts')
    <script>
        $('document').ready(function () {
            $('.delete').on('click', function () {
                var $del = confirm('Are you sure you want to delete?');
                if(!$del){
                    return;
                }
                var element = $(this);
                var url = "{{ route('admin.subject.delete') }}";
                var subject = element.data('subject');
                $.ajax(url, {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'accept': 'application/json'
                    },
                    method: 'POST',
                    data: {
                        subject: subject
                    },
                    success: function(data){
                        if(data.success){
                            window.location.href = data.redirect;
                        }else{
                            alert('Unable to delete. Try Again');
                        }
                    },
                    failure: function () {
                        alert('An error occured while deleting. Try Again');
                    }
                });
            })
        });
    </script>
@endpush