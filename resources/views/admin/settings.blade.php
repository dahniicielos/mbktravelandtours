@extends('admin.master')

@section('title', 'ADMIN - Settings')

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
        <div class="col">
            <div class="card white card-light">
                {!! Form::open(['role' => 'form', 'data-toggle' => 'validator']) !!}
                    <div class="head">
                        <h6 class="text-blue-dark text-uppercase">SETTINGS</h6>
                        <hr>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    {!! Form::label('email_address', 'Email address', ['class' => 'form-label']) !!}
                                    {!! Form::text('email_address', $homepage->email_address, ['class' => 'form-control', 'required' => 'required']) !!}
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    {!! Form::label('address', 'Address', ['class' => 'form-label']) !!}
                                    {!! Form::text('address', $homepage->address, ['class' => 'form-control', 'required' => 'required']) !!}
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    {!! Form::label('phone_number', 'Phone number', ['class' => 'form-label']) !!}
                                    {!! Form::text('phone_number', $homepage->phone_number, ['class' => 'form-control', 'required' => 'required']) !!}
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    {!! Form::label('tax', 'Tax', ['class' => 'form-label']) !!}
                                    {!! Form::number('tax', $homepage->tax, ['class' => 'form-control', 'required' => 'required']) !!}
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="footer">
                        <div class="row">
                            <div class="col">
                                <button class="btn btn-primary pull-right">Update</button>
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>



@endsection

@section('modified-script')
    <script type="text/javascript">
    </script>
@endsection