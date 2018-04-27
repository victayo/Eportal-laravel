@extends('admin.admin')
@section('title', 'Session')
@section('page-title', 'Sessions')
@section('content')
<div class="card mb-3">
    <div class="card-header">
            <i class="fa fa-list"></i> Session Lists
        <a href="{{ route('admin.session.create') }}" class="btn btn-primary" style="float: right">Create New Session</a>
    </div>
        @if($sessions->count())
            <div class="table-responsive">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr class="heading">
                                <th><input type="checkbox"></th>
                                <th class="column-title property-column-title" style="display: table-cell; text-align: right">s/n</th>
                                <th class="column-title property-column-title" style="display: table-cell; text-align: right">Name</th>
                                <th class="column-title property-column-title" style="display: table-cell; text-align: right">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sessions as $session)
                                @if($loop->index % 2)
                                    <tr class="even">
                                @else
                                    <tr class="odd">
                                        @endif
                                        <td style="text-align:left"><input type="checkbox"></td>
                                        <td style="text-align: right">{{$loop->index + 1}}</td>
                                        <td style="text-align: right"><a href="{{ route('admin.session.terms', ['session' => $session->getId()]) }}">{{ $session->getName() }}</a></td>
                                        <td style="text-align: right">
                                            <a class="btn btn-primary" href="{{ route('admin.session.edit', ['session' => $session->getId()]) }}">Edit</a>
                                            <button class="btn btn-danger delete" data-session="{{$session->getId()}}">Delete</button>
                                        </td>
                                    </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            <div class="card-body text-center">
                <p class="card-text">No sessions registered</p>
                <a href="{{ route('admin.session.create') }}" class="btn btn-primary">Register a session</a>
            </div>
        @endif
</div>

@endsection
@push('scripts')
    <script>
        $('document').ready(function () {
            $('.delete').on('click', function () {
                var $del = confirm('Are you sure you want to delete');
                if(!$del){
                    return;
                }
                var element = $(this);
                var url = "{{ route('admin.session.delete') }}";
                var session = element.data('session');
                $.ajax(url, {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        accept: 'application/json'
                    },
                    method: 'POST',
                    data: {
                        session: session
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