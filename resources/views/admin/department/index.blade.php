@extends('admin.admin')
@section('title', 'Departments')
@section('page-title', 'Departments')
@section('content')
    <div class="card mb-3">
        <div class="card-header">
             <a href="{{ route('admin.department.create') }}" class="btn btn-primary" style="float: right">Create New Department</a>
        </div>
        @if($departments->count())
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr class="heading">
                            <th><input type="checkbox" id="check-all" class="flat" ></th>
                            <th class="column-title property-column-title" style="display: table-cell; text-align: right">s/n</th>
                            <th class="column-title property-column-title" style="display: table-cell; text-align: right">Name</th>
                            <th class="column-title property-column-title" style="display: table-cell; text-align: right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($departments as $department)
                        @if($loop->index % 2)
                            <tr class="even">
                        @else
                            <tr class="odd">
                                @endif
                                <td style="text-align:left"><input type="checkbox"></td>
                                <td class="property-column-data text-right">{{$loop->index + 1}}</td>
                                <td class="property-column-data text-right">{{ $department->getName() }}</td>
                                <td class="property-column-data text-right" style="text-align: right">
                                    <a class="btn btn-default" href="{{ route('admin.department.edit', ['class' => $department->getId()]) }}">Edit</a>
                                    <button class="btn btn-danger delete" href="{{ route('admin.department.delete') }}" data-department="{{$department->getId()}}">Delete</button>
                                </td>
                            </tr>
                            @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="card-body text-center">
                <p>No registered departments</p>
                <a class="btn btn-primary" href="{{ route('admin.department.create') }}">Register Department</a>
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
                var url = "{{ route('admin.department.delete') }}";
                var department = element.data('department');
                $.ajax(url, {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'accept': 'application/json'
                    },
                    method: 'POST',
                    data: {
                        department: department
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