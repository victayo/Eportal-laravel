@extends('admin.admin')
@section('title', 'Department')
@section('page-title', 'Department - '.ucwords($department->getName()))
@section('content')
    <div class="card mb-3">
        <div class="card-header">
            {{ ucwords($department->getName()) }} Subjects
            <a href="{{ route('admin.department.addSubject', ['school' => $school->getId(), 'class' => $class->getId(), 'department' => $department->getId()]) }}"
               class="btn btn-primary"
               style="float: right;">Add Subject
            </a>
        </div>
        @if($subjects->count())
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th><input type="checkbox"></th>
                        <th class="column-title property-column-title text-right">s/n</th>
                        <th class="column-title property-column-title text-right">Name</th>
                        <th class="column-title property-column-title text-right">Action</th>
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
                                <td class="property-column-data text-right">
                                    {{ $subject->getName() }}
                                </td>
                                <td class="property-column-data text-right">
                                    <button class="btn btn-danger remove-class" href="{{ route('admin.department.removeSubject') }}" data-school="{{$school->getId() }}" data-eportal_class="{{ $class->getId() }}" data-department="{{ $department->getId() }}" data-subject="{{ $subject->getId() }}">Remove</button>
                                </td>
                            </tr>
                            @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="card-text text-center mb-2">
                <p class="card-text">No registered subjects for <strong>{{$department->getName()}}</strong></p>
                <a class="btn btn-primary" href=" {{ route('admin.department.addSubject', ['school' => $school->getId(), 'class' => $class->getId(), 'department' => $department->getId()]) }} ">Click here to add subjects</a>
            </div>
        @endif
    </div>
@endsection
@push('scripts')
<script>
    $('document').ready(function(){
        $('.remove-class').on('click', function(){
            var del = confirm('Are you sure you want to remove?');
            if(!del){
                return;
            }
            var element = $(this);
            var url = "{{ route('admin.department.removeSubject') }}";
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
                    department: element.data('department'),
                    subjects: [element.data('subject')]
                },
                success: function(data){
                    if(data.success) {
                        window.location.href = data.redirect;
                    }else {
                        alert('Unable to remove. Try again');
                    }
                },
                failure: function () {
                    alert('An error occured while removing. Try Again');
                }
            })
        });
    })
</script>
@endpush