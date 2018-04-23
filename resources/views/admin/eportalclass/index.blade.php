@extends('admin.admin')
@section('title', 'Classes')
@section('page-title', 'Classes')
@section('content')
<div class="row">
    <div class="col-md-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Schools</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a href="{{ route('admin.class.create') }}" class="btn btn-primary">Create New Class</a> </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-striped jambo_table bulk_action">
                        <thead>
                            <tr class="heading">
                                <th>
                                    <div class="icheckbox_flat-green" style="position: relative; text-align: left">
                                        <input type="checkbox" id="check-all" class="flat" style="position: absolute; opacity: 0;">
                                        <ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                    </div>
                                </th>
                                <th class="column-title property-column-title" style="display: table-cell; text-align: right">s/n</th>
                                <th class="column-title property-column-title" style="display: table-cell; text-align: right">Name</th>
                                <th class="column-title property-column-title" style="display: table-cell; text-align: right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($classes as $class)
                            @if($loop->index % 2)
                                <tr class="even pointer">
                            @else
                                <tr class="odd pointer">
                            @endif
                                <td class="a-center" style="text-align:left">
                                    <div class="icheckbox_flat-green" style="position: relative;">
                                        <input type="checkbox" class="flat" name="table_records" style="position: absolute; opacity: 0;">
                                        <ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                    </div>
                                </td>
                                <td class="property-column-data" style="text-align: right">{{$loop->index + 1}}</td>
                                <td class="property-column-data" style="text-align: right">{{ $class->getName() }}</td>
                                <td class="property-column-data", style="text-align: right">
                                    <a class="btn btn-default" href="{{ route('admin.class.edit', ['class' => $class->getId()]) }}">Edit</a>
                                    <button class="btn btn-danger delete" href="{{ route('admin.class.delete') }}" data-class="{{$class->getId()}}">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
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
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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