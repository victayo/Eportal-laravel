@extends('admin.admin')
@section('title', 'School')
@section('page-title', 'Schools')
@section('content')
<div class="card mb-3">
    <div class="card-header">
            <i class="fa fa-list"></i> School Lists
        <a href="{{ route('admin.school.create') }}" class="btn btn-primary" style="float: right">Create New School</a>
    </div>
        @if($schools->count())
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
                            @foreach($schools as $school)
                                @if($loop->index % 2)
                                    <tr class="even">
                                @else
                                    <tr class="odd">
                                        @endif
                                        <td style="text-align:left"><input type="checkbox"></td>
                                        <td style="text-align: right">{{$loop->index + 1}}</td>
                                        <td style="text-align: right"><a href="{{ route('admin.school.classes', ['school' => $school->getId()]) }}">{{ $school->getName() }}</a></td>
                                        <td style="text-align: right">
                                            <a class="btn btn-primary" href="{{ route('admin.school.edit', ['school' => $school->getId()]) }}">Edit</a>
                                            <button class="btn btn-danger delete" data-school="{{$school->getId()}}">Delete</button>
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
                <p class="card-text">No schools registered</p>
                <a href="{{ route('admin.school.create') }}" class="btn btn-primary">Register a school</a>
            </div>
        @endif
</div>

@endsection
@push('scripts')
    <script>
        $('document').ready(function () {
            $('.delete').on('click', function () {
                var $del = confirm('Are you sure you want to delete this school');
                if(!$del){
                    return;
                }
                var element = $(this);
                var url = "{{ route('admin.school.delete') }}";
                var school = element.data('school');
                $.ajax(url, {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        accept: 'application/json'
                    },
                    method: 'POST',
                    data: {
                        school: school
                    },
                    success: function(data){
                        if(data.success){
                            window.location.href = data.redirect;
                        }else{
                            alert('Unable to delete this school. Try Again');
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