@extends('admin.admin')
@section('title', 'Class')
@section('page-title', 'Class - '.ucwords($class->getName()))
@section('content')
    <div class="card mb-3">
        <div class="card-header">
            {{ ucwords($class->getName()) }} Departments
            <a href="{{ route('admin.class.addDepartment', ['school' => $school->getId(), 'class' => $class->getId()]) }}"
               class="btn btn-primary" style="float: right;">
                Add Department
            </a>
        </div>
        @if($departments->count())
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr class="heading">
                        <th> <input type="checkbox"></th>
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
                                <td style="text-align:left"><input type="checkbox" ></td>
                                <td class="property-column-data text-left">{{$loop->index + 1}}</td>
                                <td class="property-column-data text-right">
                                    <a href="{{ route('admin.department.subjects', ['school' => $school->getId(), 'class' => $class->getId(), 'department' => $department->getId()]) }}">
                                        {{ $department->getName() }}
                                    </a>
                                </td>
                                <td class="property-column-data text-right">
                                    <button class="btn btn-danger remove-class" href="{{ route('admin.class.removeDepartment') }}" data-school="{{$school->getId() }}" data-eportal_class="{{ $class->getId() }}" data-department="{{ $department->getId() }}">Remove</button>
                                </td>
                            </tr>
                            @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="card-body text-center">
                <p class="card-text">No registered departments for <strong>{{$class->getName()}}</strong></p>
                <a class="btn btn-primary" href=" {{ route('admin.class.addDepartment', ['school' => $school->getId(), 'class' => $class->getId()]) }} ">Click here to add departments</a>
            </div>
        @endif
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