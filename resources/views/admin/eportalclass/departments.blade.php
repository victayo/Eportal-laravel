@extends('admin.admin')
@section('title', 'Class')
@section('page-title', 'Class - '.ucwords($class->getName()))
@section('content')
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2> {{ ucwords($class->getName()) }} Departments</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a href="{{ route('admin.class.addDepartment', ['school' => $school->getId(), 'class' => $class->getId()]) }}" class="btn btn-primary">Add Department</a> </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    @if($departments->count())
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
                            @foreach($departments as $department)
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
                                        <td class="property-column-data" style="text-align: right">
                                            <a href="{{ route('admin.school.classes', ['school' => $school->getId(), 'class' => $class->getId(), 'department' => $department->getId()]) }}">
                                                {{ $department->getName() }}
                                            </a>
                                        </td>
                                        <td class="property-column-data", style="text-align: right">
                                            <button class="btn btn-danger remove-class" href="{{ route('admin.school.removeClass') }}" data-school="{{$school->getId() }}" data-eportal_class="{{ $class->getId() }}" data-department="{{ $department->getId() }}">Remove</button>
                                        </td>
                                    </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                        @else
                        <div class="well">
                            <p>No registered departments for <strong>{{$class->getName()}}</strong></p>
                            <a class="btn btn-primary" href=" {{ route('admin.class.addDepartment', ['school' => $school->getId(), 'class' => $class->getId()]) }} ">Click here to add departments</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
    $('document').ready(function(){
        $('.remove-class').on('click', function(){
            var del = confirm('Are you sure you want to remove this department?');
            if(!del){
                return;
            }
            var element = $(this);
            var url = "{{ route('admin.class.removeDepartment') }}";
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    accept: 'Application/json'
                },
                url: url,
                method: 'POST',
                data : {
                    school: element.data('school'),
                    class: element.data('eportal_class'),
                    departments: [element.data('department')]
                },
                success: function(data){
                    if(data.success) {
                        window.location.href = data.redirect;
                    }else {
                        alert('Department could not be removed. Try again');
                    }
                },
                failure: function () {
                    alert('An error occured while removing department. Try Again');
                }
            })
        });
    })
</script>
@endpush