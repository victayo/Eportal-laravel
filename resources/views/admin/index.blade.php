@extends('admin.admin')
@section('title', ucwords($property_name))
@section('page-title', str_plural(ucwords($property_name)))
@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <i class="fa fa-list"></i> <span class="text-capitalize">{{$property_name}} lists</span>
            <a href="{{ $create_new_link }}" class="btn btn-primary text-capitalize" style="float: right">create new {{$property_name}}</a>
        </div>
        @if($properties->count())
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
                            @foreach($properties as $property)
                                @if($loop->index % 2)
                                    <tr class="even">
                                @else
                                    <tr class="odd">
                                        @endif
                                        <td style="text-align:left"><input type="checkbox"></td>
                                        <td style="text-align: right">{{$loop->index + 1}}</td>
                                        <td style="text-align: right">{{ $property->getName() }}</td>
{{--                                        <td style="text-align: right"><a href="{{ route('admin.school.classes', [$property_name => $property->getId()]) }}">{{ $property->getName() }}</a></td>--}}
                                        <td style="text-align: right">
                                            @php
                                                $new_edit = str_replace('?', $property->getId(), $edit_link);
                                            @endphp
                                            <a class="btn btn-primary" href="{{ $new_edit  }}">Edit</a>
                                            <button class="btn btn-danger delete" data-{{$property_name}}="{{$property->getId()}}">Delete</button>
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
                <p class="card-text">No {{ str_plural(ucwords($property_name)) }} registered</p>
                <a href="{{ $create_link }}" class="btn btn-primary">Register a {{ $property_name }}</a>
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
                var url = "{{ $delete_link }}";
                var property_name = "{{ $property_name }}";
                var property = element.data(property_name);
                $.ajax(url, {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        accept: 'application/json'
                    },
                    method: 'POST',
                    data: {
                        "{{$property_name}}" : property
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