@extends('admin.admin')
@section('title', 'School')
@section('page-title', 'Schools')
@section('content')
<div class="row">
    <div class="col-md-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Schools</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-expanded="false"><i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Settings 1</a></li>
                            <li><a href="#">Settings 2</a></li>
                        </ul>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a></li>
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
                        @foreach($schools as $school)
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
                                <td class="property-column-data" style="text-align: right">{{ $school->getName() }}</td>
                                <td class="property-column-data", style="text-align: right">
                                    <a class="btn btn-default" href="{{ route('admin.school.edit') }}">Edit</a>
                                    <a class="btn btn-danger" href="{{ route('admin.school.delete') }}">Delete</a>
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