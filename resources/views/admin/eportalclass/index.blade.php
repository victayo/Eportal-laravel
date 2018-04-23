@extends('admin.admin')
@section('title', 'Classes')
@section('page-title', 'Classes')
@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <i class="fa fa-list"></i> Class Lists
            <a href="{{ route('admin.class.create') }}" class="btn btn-primary" style="float: right">Create New Class</a>
        </div>
        @if($classes->count())
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
                            @foreach($classes as $class)
                                @if($loop->index % 2)
                                    <tr class="even">
                                @else
                                    <tr class="odd">
                                        @endif
                                        <td style="text-align:left"><input type="checkbox"></td>
                                        <td style="text-align: right">{{$loop->index + 1}}</td>
                                        <td style="text-align: right">{{ $class->getName() }}</td>
                                        <td style="text-align: right">
                                            <a class="btn btn-primary" href="{{ route('admin.class.edit', ['class' => $class->getId()]) }}">Edit</a>
                                            <button class="btn btn-danger delete" href="{{ route('admin.class.delete') }}" data-class="{{$class->getId()}}">Delete</button>
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
                        <p class="card-text">No classes registered</p>
                        <a href="{{ route('admin.class.create') }}" class="btn btn-primary">Register a class</a>
                    </div>
            @endif
    </div>
@endsection
@push('scripts')
    <script>
        $('document').ready(function () {
            $('.delete').on('click', function () {
                var $del = confirm('Are you sure you want to delete this class');
                if(!$del){
                    return;
                }
                var element = $(this);
                var url = "{{ route('admin.class.delete') }}";
                var $class = element.data('class');
                $.ajax(url, {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        accept: 'application/json'
                    },
                    method: 'POST',
                    data: {
                        class: $class
                    },
                    success: function(data){
                        if(data.success){
                            window.location.href = data.redirect;
                        }else{
                            alert('Unable to delete this class. Try Again');
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