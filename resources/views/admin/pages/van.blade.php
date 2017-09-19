@extends('admin.master')

@section('title', 'ADMIN - Pages > Van')

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
    </style>
@endsection

@section('content')
<div id="content" class="bg-light-gray">
    <div class="row">
        <div class="col"><p>VAN PAGE</p></div>
        <div class="col">
            <div class="pull-right"><button class="btn btn-primary" onclick="toggleAddVan()">Add Van</button></div>
        </div>
    </div>
    <div class="row">
        @foreach ($vans as $van)
            <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                <div class="card white card-light">
                    <img src="{!! url('/') !!}/{!! $van->van_image !!}" style="height:150px">
                    <div class="body">
                        <a href="" class="text-blue-dark"><b>{!! $van->brand !!}&nbsp;({!! $van->model !!})<br>{!! $van->no_of_seats !!}-seater</b></a>
                        <hr>
                        <p>
                            
                            {!! $van->description !!}<br><br>
                            <button class="btn btn-danger text-uppercase pull-right" onclick="deleteVan({!! $van->id !!})">Delete</button>
                            <button  class="btn btn-default text-uppercase pull-right" onclick="toggleEditVan({!! $van->id !!})">Edit</button>
                            
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
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

<div class="modal fade" id="van-modal" tabindex="-1" role="dialog" aria-labelledby="vanEditLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! Form::open(['id' => 'van-form', 'url' => url('/').'/admin/pages/vans/update', 'role' => 'form', 'data-toggle' => 'validator', 'enctype' => 'multipart/form-data']) !!}
                <div class="modal-header">
                    <h5 class="modal-title" id="van-modal-title">Edit Van</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                            <div class="form-group">
                                {!! Form::text('brand', '', ['class' => 'form-control', 'placeholder' => 'Enter Brand', 'id' => 'modal-brand', 'required' => 'required']) !!}
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                            <div class="form-group">
                                {!! Form::text('model', '', ['class' => 'form-control', 'placeholder' => 'Enter Model', 'id' => 'modal-model', 'required' => 'required']) !!}
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <div class="form-group">
                                {!! Form::number('no_of_seats', '', ['class' => 'form-control', 'placeholder' => 'Enter No of Seats', 'id' => 'modal-no-of-seats', 'required' => 'required', 'min' => '1']) !!}
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                {!! Form::textarea('description', '', ['class' => 'form-control', 'placeholder' => 'Enter Description', 'id' => 'modal-description', 'required' => 'required']) !!}
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <img id="modal-van-image" style="height:150px">
                                {!! Form::file('van_image', ['id' => 'van-image', 'required'=>'required']) !!}
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



@endsection

@section('modified-script')
    <script type="text/javascript">
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

        function deleteVan(id) {
            swal({
                title: "Delete Van?",
                type: "info",
                html: "Are you sure you want to delete this van?",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "No",
                confirmButtonText: "Yes"
            }).then(function() {
                <?php

                    $link = url('/').'/admin/pages/vans/delete/';
                ?>
                window.location.href = '{!! $link !!}'+id;
            });
        }

        function toggleEditVan(id) {
            $('#van-modal-title').html('Edit Van');

            var link = '{!! url("/") !!}'+'/admin/pages/vans/update/';
            $('#van-form').attr('action', link+id);
            $('.help-block').html("");
            $('#van-image').removeAttr("required");
            $('#modal-van-image').show();
            $.ajax({
                url: "{!! url('/') !!}/admin/ajax/van/get-info/"+id,
                dataType: 'json',
                delay: 250,
                data: {
                    'id': id
                },
                success: function (data) {
                    //alert(data);
                    //console.log(data);
                    $('#modal-brand').val(data[0].brand);
                    $('#modal-model').val(data[0].model);
                    $('#modal-no-of-seats').val(data[0].no_of_seats);
                    $('#modal-description').val(data[0].description);
                    $('#modal-van-image').attr('src', "{!! url('/') !!}"+"/"+data[0].van_image);
                    
                    
                },
                error: function (jqXHR, exception) {
                    console.log(exception);
                },
                cache: true
            });
            $("#van-modal").modal("toggle");
        }

        function toggleAddVan() {
            $('#van-modal-title').html('Add Van');

            var link = '{!! url("/") !!}'+'/admin/pages/vans/add';
            $('#van-form').attr('action', link);
            $('.help-block').html("");
            $('#modal-brand').val("");
            $('#modal-model').val("");
            $('#modal-no-of-seats').val("");
            $('#modal-description').val("");
            $('#modal-van-image').hide();
            $('#van-image').attr("required", "required");
            $("#van-modal").modal("toggle");
        }
    </script>
@endsection