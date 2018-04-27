@extends('admin.admin')
@section('title', 'Session')
@section('page-title', 'Session - '.ucwords($session->getName()))
@section('content')
    <div class="card mb-3">
        <div class="card-header">
            Terms
            <a href="{{ route('admin.session.addTerm', ['session' => $session->getId()]) }}"
               class="btn btn-primary" style="float:right;">Add Term
            </a>
        </div>
            @if($terms->count())
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
                        @foreach($terms as $term)
                            @if($loop->index % 2)
                                <tr class="even">
                            @else
                                <tr class="odd">
                                    @endif
                                    <td style="text-align:left"><input type="checkbox"></td>
                                    <td class="property-column-data" style="text-align: right">{{$loop->index + 1}}</td>
                                    <td class="property-column-data" style="text-align: right">
                                            {{ $term->getName() }}
                                    </td>
                                    <td class="property-column-data" style="text-align: right">
                                        <button class="btn btn-danger remove-term"
                                                data-session="{{$session->getId() }}"
                                                data-term="{{ $term->getId() }}">Remove
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center mb-2">
                    <p class="card-text">No registered terms for <strong>{{ $session->getName() }}</strong></p>
                    <a class="btn btn-primary"
                       href="{{ route('admin.session.addTerm', ['session' => $session->getId()]) }}">
                        Click here to add terms
                    </a>
                </div>
            @endif
    </div>
@endsection

@push('scripts')
    <script>
        $('document').ready(function () {
            $('.remove-term').on('click', function () {
                var del = confirm('Are you sure you want to remove?');
                if (!del) {
                    return;
                }
                var element = $(this);
                var url = "{{ route('admin.session.removeTerm') }}";
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        accept: 'Application/json'
                    },
                    url: url,
                    method: 'POST',
                    data: {
                        session: element.data('session'),
                        terms: [element.data('term')]
                    },
                    success: function (data) {
                        if(data.success) {
                            window.location.href = data.redirect;
                        }else{
                            alert('Unable to remove. Try again')
                        }
                    },
                    failure: function () {
                        alert('An error occurred while removing. Try Again');
                    }
                })
            });
        })
    </script>
@endpush