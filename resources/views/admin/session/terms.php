@extends('admin.admin')
@section('title', 'School')
@section('page-title', 'School - '.ucwords($school->getName()))
@section('content')
    <div class="card mb-3">
        <div class="card-header">
            Classes
            <a href="{{ route('admin.school.addClass', ['school' => $school->getId()]) }}"
               class="btn btn-primary" style="float:right;">Add Class
            </a>
        </div>
            @if($classes->count())
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr class="heading">
                            <th><input type="checkbox">
                            </th>
                            <th class="column-title property-column-title" style="display: table-cell; text-align: right">s/n
                            </th>
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
                                    <td class="property-column-data" style="text-align: right">{{$loop->index + 1}}</td>
                                    <td class="property-column-data" style="text-align: right">
                                        <a href="{{ route('admin.class.departments', ['school' => $school->getId(), 'class' => $class->getId()]) }}">
                                            {{ $class->getName() }}
                                        </a>
                                    </td>
                                    <td class="property-column-data" style="text-align: right">
                                        <button class="btn btn-danger remove-class"
                                                href="{{ route('admin.school.removeClass') }}"
                                                data-school="{{$school->getId() }}"
                                                data-eportal_class="{{ $class->getId() }}">Remove
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center mb-2">
                    <p class="card-text">No registered classes for <strong>{{$school->getName()}}</strong></p>
                    <a class="btn btn-primary"
                       href="{{ route('admin.school.addClass', ['school' => $school->getId()]) }}">
                        Click here to add classes
                    </a>
                </div>
            @endif
    </div>

@endsection
@push('scripts')
    <script>
        $('document').ready(function () {
            $('.remove-class').on('click', function () {
                var del = confirm('Are you sure you want to remove?');
                if (!del) {
                    return;
                }
                var element = $(this);
                var url = "{{ route('admin.school.removeClass') }}";
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        accept: 'Application/json'
                    },
                    url: url,
                    method: 'POST',
                    data: {
                        school: element.data('school'),
                        classes: [element.data('eportal_class')]
                    },
                    success: function (data) {
                        if(data.success) {
                            window.location.href = data.redirect;
                        }else{
                            alert('Unable to remove. Try again')
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