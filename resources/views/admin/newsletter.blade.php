@extends('admin.master')

@section('title', 'MBK - Newsletter')

@section('modified-style')
    <style type="text/css">
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
    <!-- Page Content Holder -->
    <div id="content" class="bg-light-gray">

        <div class="row" style="margin-top: 20px">
            <div class="col"><small>Subscribers</small></div>
            <div class="col text-right"><a href="{!! url('/') !!}/admin/newsletter/write-message" class="btn btn-primary">Write A Message</a></div>
        </div>

        <div class="card white card-light" class="margin-top: 20px">
            <div class="head bg-blue">
                <h6 class="text-white">Subscribers</h6>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table" id="subscribers-table">
                        <thead>
                            <tr>
                                <th>Email</th>
                                <th>Date Subscribed</th>
                                <th>&nbsp;</th>
                                <th>ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modified-script')
    <script type="text/javascript">


        //===================  USERS  ===================//


        var s_table = $('#subscribers-table').DataTable({
            "resposive": true,
            "ajax": "{!! url('/') !!}/admin/ajax/newsletter/get-all",
            "columns": [
                { "data": "email" },
                { "data": "date_subscribed" },
                { "data": "unsubscirbe_btn" },
                { "data": "id"}
            ],
            "columnDefs": [
                {
                    "targets": [0],
                    "width": "15%",
                },
                {
                    "targets": [1],
                    "width": "20%",
                },
                {
                    "targets": [2],
                    "width": "5%",
                },
                {
                    "targets": [ 3 ],
                    "visible": false,
                    "searchable": false
                }
            ]
        }).columns.adjust().draw();

        

        function unsubscirbe_user(id, email) {
            swal({
                title: "Are you sure?",
                type: "info",
                html: "Are you sure you want to unsubscribe this user : "+email+"?",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "No",
                confirmButtonText: "Yes"
            }).then(function() {
                $.ajax({
                    url: "{!! url('/') !!}/admin/ajax/newsletter/unsubscribe/"+id,
                    delay: 250,
                    data: {
                        'id': id
                    },
                    success: function (data) {
                        if (data == "success") {
                            swal({
                                title: "Success",
                                type: "success",
                                html: "<div class=\"swal-success-status\">The user : "+email+", has been successfully unsubscribed.</div>"
                            });
                        }
                        else {
                            swal({
                                title: "Error",
                                type: "error",
                                html: "<div class=\"swal-success-status\">Something went wrong, please try again later.</div>"
                            });
                        }
                        s_table.ajax.reload();
                        
                    },
                    error: function (jqXHR, exception) {
                        console.log(exception);
                    },
                    cache: true
                });
            });
        }
        
    </script>
@endsection