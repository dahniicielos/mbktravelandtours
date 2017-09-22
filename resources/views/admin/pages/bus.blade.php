@extends('admin.master')

@section('title', 'ADMIN - Pages > Bus')

@section('modified-style')
    <style type="text/css">
        #content > .row{
            margin-bottom: 20px;
        }
        
        .card .head{
            padding-bottom: 0px;
        }
        
        .card .body{
            padding-top: 5px;
        }
        
        .card .body p{
            font-size: 13px;
        }
        
        .tab-pane img{
            width: 50px;
        }
        .card{
            margin: 10px 0px 20px 0px;
        }

        #main .card{
            padding: 0px;
        }

        #quick-stat p{
            font-size: 13px;
            margin: 0px 0px 10px 0px;
        }

        #quick-stat h5{
            margin: 0px 0px 5px 0px
        }

        .card h6{
            margin: 5px 0px 0px 0px;
        }

        .card small{
            font-size: 12px;
        }

        table thead tr th,
        table tbody tr td{
            font-size: 13px;
        }

        .table th{
            border-top: none;
        }

        table tbody tr{
            cursor: pointer;
        }

        .table tbody tr{
            transition: all ease 0.3s;
        }

        .table tbody tr:hover{
            background: #2196F3;
        }

        .table tbody tr:hover td{
            color: #FFFFFF;
        }
    </style>
@endsection

@section('content')
<div id="content" class="bg-light-gray">
    <div class="row">
        <div class="col"><p>BUS PAGE</p></div>
        <button class="btn btn-primary pull-right" onclick="toggleNewLocation()">New Location</button>
    </div>
    
    <div class="row">
        <div class="col">
            <div class="card white card-light">
                <div class="head">
                    <div  class="col">
                        <h6 class="text-blue-dark text-uppercase">Routes</h6>
                        <button class="btn btn-primary pull-right" onclick="toggleNewRoute()">New Route</button>
                    </div>
                    <hr>
                </div>
                <div class="body">
                    <div class="row">
                        <div class="col">
                            <div class="table-responsive">
                                <table class="table" id="routes-table">
                                    <thead>
                                        <tr>
                                            <th>Origin</th>
                                            <th>Destination</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card white card-light">
                <div class="head">
                    <h6 class="text-blue-dark text-uppercase">Steps</h6>
                    <hr>
                </div>
                <div class="body">
                    <div class="row">
                        <div class="col-4">
                            <div class="list-group" id="list-tab" role="tablist">
                                <?php $counter = 0; ?>
                                @foreach ($steps as $step)
                                    <a class="list-group-item list-group-item-action
                                        @if($counter == 0)
                                            active
                                        @endif
                                    " id="list-{!! $step->step_number !!}-list" data-toggle="list" href="#list-{!! $step->step_number !!}" role="tab" aria-controls="{!! $step->step_number !!}">Step {!! $step->step_number !!}</a>

                                    <?php $counter++; ?>
                                @endforeach
                                    
                            </div>
                        </div>
                        
                        <div class="col-8">
                            <div class="tab-content" id="nav-tabContent">
                                <?php $counter = 0; ?>
                                @foreach ($steps as $step)
                                    <div class="tab-pane fade
                                    @if($counter == 0)
                                       show active
                                    @endif
                                    " id="list-{!! $step->step_number !!}" role="tabpanel" aria-labelled-by="list-{!! $step->step_number !!}-list">
                                        <p>
                                            {!! $step->step_desc !!}<br><br>
                                            <button class="btn btn-default" onclick="edit_step({!! $step->id !!}, '{!! $step->step_desc !!}', {!! $step->step_number !!})">Edit</button>
                                        </p>
                                    </div>
                                    <?php $counter++; ?>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col">
            <div class="card white card-light">
                <div class="head">
                    <h6 class="text-blue-dark text-uppercase">
                        Frequently Asked Questions
                    </h6>
                    <hr>
                </div>
                <div class="body">
                    <div class="row">
                        <div class="col-4">
                            <div class="list-group" id="list-tab" role="tablist">
                                <?php $counter = 0; ?>
                                @foreach ($faqs as $faq)
                                    <a class="list-group-item list-group-item-action
                                    @if ($counter == 0)
                                        active
                                    @endif
                                    " id="faq-{!! $faq->id !!}-list" data-toggle="list" href="#faq-{!! $faq->id !!}" role="tab" aria-controls="{!! $faq->id !!}">{!! $faq->question !!}</a>
                                    <?php $counter++; ?>
                                @endforeach
                                
                            </div>
                        </div>
                        
                        <div class="col-8">
                            <div class="tab-content" id="nav-tabContent">
                                <?php $counter = 0; ?>
                                @foreach ($faqs as $faq)
                                    <div class="tab-pane fade
                                    @if ($counter == 0)
                                        show active
                                    @endif
                                    " id="faq-{!! $faq->id !!}" role="tabpanel" aria-labelled-by="faq-{!! $faq->id !!}-list">
                                        <p>
                                            {!! $faq->answer !!}<br><br>
                                            <button class="btn btn-danger" 
                                            @if ($faq->is_hidden == 0)
                                                onclick="hideFaq({!! $faq->id !!})"> Hide
                                            @else
                                                onclick="unhideFaq({!! $faq->id !!})"> Unhide
                                            @endif
                                            </button>
                                            
                                        </p>
                                    </div>
                                    <?php $counter++; ?>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="step-modal" tabindex="-1" role="dialog" aria-labelledby="vanRentalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! Form::open(['id' => 'step-form', 'url' => url('/').'/admin/pages/steps/update', 'role' => 'form', 'data-toggle' => 'validator']) !!}
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Edit Step</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <textarea class="form-control" id="description" name="description" rows="10" required="required"></textarea>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<div class="modal fade" id="manage-route-modal" tabindex="-1" role="dialog" aria-labelledby="manageRouteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! Form::open(['url' => url('/').'/admin/routes/new', 'role' => 'form', 'data-toggle' => 'validator', 'id' => 'manage-route-form']) !!}
            <div class="modal-header">
                <h5 class="modal-title" id="manage-route-modal-title">New Route</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <table>
                            <tr>
                                <td width="150">Origin: </td>
                                <td><div class="form-group">{!! Form::select('origin', $locations, 0, ['class' => 'form-control', 'id' => 'origin-select', 'required' => 'required']) !!}<br><div class="help-block"></div></div></td>
                            </tr>
                            <tr>
                                <td>Destination:</td>
                                <td><div class="form-group">{!! Form::select('destination', $locations, 0, ['class' => 'form-control', 'id' => 'destination-select', 'required' => 'required']) !!}<br><div class="help-block"></div></div></td>
                            </tr>
                            <tr id="drop-off-point-tr">
                                <td>Drop Off Point:</td>
                                <td><div class="form-group">{!! Form::select('drop_off_point', $locations, 0, ['class' => 'form-control', 'id' => 'drop-off-point-select', 'required' => 'required']) !!}<br><div class="help-block"></div></div></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success" id="route-save-btn">Save</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<div class="modal fade" id="manage-location-modal" tabindex="-1" role="dialog" aria-labelledby="manageLocationLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="manageLocationLabel">New Location</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {!! Form::open(['url' => url('/').'/admin/bus-travel-locations/new', 'role' => 'form', 'data-toggle' => 'validator', 'id' => 'manage-location-form']) !!}
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                           
                            <table>
                                <tr>
                                    <td width="150">Location: </td>
                                    <td>
                                        <div class="form-group">
                                            {!! Form::text('location_name', '', ['required' => 'required', 'class' => 'form-control', 'id' => 'manage-location-name-form']) !!}
                                            <div class="help-block with-errors"></div>
                                        </div>
                                        <div id="location-msg">
                                        </div>
                                    </td>
                            </table>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="location-delete-btn">Delete</button>
                    <button type="submit" class="btn btn-success">Save</button>

                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<div class="modal fade" id="route-modal" tabindex="-1" role="dialog" aria-labelledby="routeLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="routeLabel">Route Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <table>
                            <tr>
                                <td width="150">Origin:</td>
                                <td><b><span id="route-modal-origin"></span></b></td>
                            </tr>
                            <tr>
                                <td>Destination:</td>
                                <td><b><span id="route-modal-destination"></span></b></td>
                            </tr>
                            <tr>
                                <td>Drop Off Points:</td>
                                <td><b><span id="route-modal-possible-drop-off-points"></span></b></td>
                            </tr>
                            <tr>
                                <td>New Drop Off Point:</td>
                                {!! Form::open(['url' => url('/').'/admin/bus/new-drop-off-point', 'role' => 'form', 'data-toggle' => 'validator', 'id' => 'new-drop-off-point-form']) !!}
                                {!! Form::hidden('origin_id', '', ['id' => 'new-drop-off-point-origin-hidden']) !!}
                                {!! Form::hidden('destination_id', '', ['id' => 'new-drop-off-point-destination-hidden']) !!}
                                <td>
                                    <div>{!! Form::select('drop_off_point_id', $locations, 0, ['class' => 'form-control', 'id' => 'new-drop-off-point-select']) !!}&nbsp;<button type="submit" class="btn btn-primary">Add</button></td>
                                {!! Form::close() !!}
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="route-edit-btn">Edit</button>
                <button type="button" class="btn btn-danger" id="route-delete-btn">Delete</button>
            </div>
        </div>
    </div>
</div>



@endsection

@section('modified-script')
    <script type="text/javascript">
        var r_table = $('#routes-table').DataTable({
            "resposive": true,
            "ajax": "{!! url('/') !!}/admin/ajax/bus/routes/get-all",
            "columns": [
                { "data": "origin" },
                { "data": "destination" },
            ],
            "createdRow": function(row, data, dataIndex) {
                //console.log(data)
                $(row).attr("onclick", "toggleRouteModal("+data.origin_id+", "+data.destination_id+")");
            },
        }).columns.adjust().draw();

        function toggleNewLocation() {
            $('#location-msg').html("");
            var link = "{!! url('/') !!}"+'/admin/bus-travel-locations/new';
            $('#manageLocationLabel').html("New Location");
            $('#manage-location-form').attr('action', link);
            $('#manage-location-name-form').val('');
            $('#location-delete-btn').hide();
            $('#location-delete-btn').removeAttr('onclick');
            $('#manage-location-modal').modal('toggle');
        }

        function toggleEditLocation(id) {
            $.ajax({

                url: "{!! url('/') !!}/admin/ajax/bus/location/get-info/"+id,
                dataType: 'json',
                delay: 250,
                success: function (data) {
                    $("#route-modal").modal("toggle");
                    $('#location-msg').html("<i>Plese note that all the routes with this location will also be changed.</i>");
                    $('#manage-location-name-form').val(data[0].location_name);
                    $('#location-delete-btn').show();
                    $('#location-delete-btn').attr('onclick', 'toggleDeleteLocation('+id+')');
                    var link = "{!! url('/') !!}"+'/admin/bus-travel-locations/edit/'+id;
                    $('#manage-location-form').attr('action', link);
                    $('#manageLocationLabel').html("Edit Location");

                },
                error: function (jqXHR, exception) {
                    console.log(exception);
                },
                cache: true
            });
            $('#manage-location-modal').modal('toggle');
        }

        function toggleDeleteLocation(id) {
            swal({
                title: "Delete Location?",
                type: "info",
                html: "Are you sure you want to delete this location? Any route having this location as an origin or destiantion will also be deleted.",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "No",
                confirmButtonText: "Yes"
            }).then(function() {
                <?php

                    $link = url('/').'/admin/bus-travel-locations/delete/';
                ?>
                window.location.href = '{!! $link !!}'+id;
            });
        }

        function toggleNewRoute() {
            var link = "{!! url('/') !!}"+'/admin/routes/new';
            $('#manage-route-modal-title').html("New Route");
            $('#manage-route-form').attr('action', link);
            $('#drop-off-point-select').attr('required', 'required');
            $('#drop-off-point-tr').show();
            $('#manage-route-modal').modal('toggle');

        }

        function removeDropOffPoint(id) {
            swal({
                title: "Remove Drop off point?",
                type: "info",
                html: "Are you sure you want to remove this drop off point from the route?",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "No",
                confirmButtonText: "Yes"
            }).then(function() {
                <?php

                    $link = url('/').'/admin/bus/drop-off-point/delete/';
                ?>
                window.location.href = '{!! $link !!}'+id;
            });
        }

        function deleteRoute(o, d) {
            swal({
                title: "Delete Route?",
                type: "info",
                html: "Are you sure you want to delete this route?",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "No",
                confirmButtonText: "Yes"
            }).then(function() {
                <?php

                    $link = url('/').'/admin/bus/routes/delete/';
                ?>
                window.location.href = '{!! $link !!}'+o+'/'+d;
            });
        }

        function toggleRouteModal(o, d) {
            $.ajax({
                url: "{!! url('/') !!}/admin/ajax/bus/routes/get-info/"+o+"/"+d,
                dataType: 'json',
                delay: 250,
                success: function (data) {
                    $('#route-modal-origin').html(data[0].origin_name);
                    $('#route-modal-destination').html(data[0].destination_name);
                    $('#route-modal-possible-drop-off-points').html(data[0].drop_off_points_names);
                    $('#new-drop-off-point-origin-hidden').val(data[0].o);
                    $('#new-drop-off-point-destination-hidden').val(data[0].d);
                    $('#route-delete-btn').attr('onclick', 'deleteRoute('+o+', '+d+')');
                    $('#route-edit-btn').attr('onclick', 'toggleEditRoute('+o+', '+d+')');
                },
                error: function (jqXHR, exception) {
                    console.log(exception);
                },
                cache: true
            });
            $("#route-modal").modal("toggle");
        }

        function toggleEditRoute(o, d) {
            $("#route-modal").modal("toggle");
            var link = "{!! url('/') !!}"+'/admin/routes/edit/';
            $('#manage-route-modal-title').html("Edit Route");
            $('#manage-route-form').attr('action', link+o+'/'+d);
            $('#drop-off-point-select').removeAttr('required');
            $('#drop-off-point-tr').hide();
            $('#origin-select').val(o);
            $('#destination-select').val(d);
            $('#manage-route-modal').modal('toggle');
        }

        function edit_step(id, desc, num) {
            $('#description').val(desc);
            $('#modal-title').html("Edit Step "+num);
            var link = '{!! url("/") !!}'+'/admin/pages/steps/update/';
            $('#step-form').attr('action', link+id);
            $('.help-block').html("");
            $('#step-modal').modal('toggle');
        }

        function hideFaq(id) {
            swal({
                title: "Hide Faq?",
                type: "info",
                html: "Are you sure you want to hide this FAQ from the users?",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "No",
                confirmButtonText: "Yes"
            }).then(function() {
                <?php

                    $link = url('/').'/admin/faqs/hide/';
                ?>
                window.location.href = '{!! $link !!}'+id;
            });
        }

        function unhideFaq(id) {
            swal({
                title: "Unhide Faq?",
                type: "info",
                html: "Are you sure you want to show this FAQ from the users?",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "No",
                confirmButtonText: "Yes"
            }).then(function() {
                <?php

                    $link = url('/').'/admin/faqs/unhide/';
                ?>
                window.location.href = '{!! $link !!}'+id;
            });
        }
    </script>
@endsection