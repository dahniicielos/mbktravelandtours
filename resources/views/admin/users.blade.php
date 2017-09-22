@extends('admin.master')

@section('title', 'MBK - Users')

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
            <div class="col"><small>Users</small></div>
        </div>

        <div class="card white card-light" class="margin-top: 20px">
            <div class="head bg-blue">
                <h6 class="text-white">Users</h6>
                <small class="text-white">Click the row to view user details</small>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table" id="users-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Date Joined</th>
                                <th>Membership</th>
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


    <!-- modals -->
    <div class="modal fade" id="user-modal" tabindex="-1" role="dialog" aria-labelledby="userLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userLabel">User Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <table>
                                <tr>
                                    <td><b><span id="user-modal-profile-picture"></span></b></td>
                                </tr>
                                <tr>
                                    <td width="150">Name: </td>
                                    <td><b><span id="user-modal-name"></span></b></td>
                                </tr>
                                <tr>
                                    <td>Birthdate &amp; Age:</td>
                                    <td><b><span id="user-modal-birthday-age"></span></b></td>
                                </tr>
                                <tr>
                                    <td>Phone Number:</td>
                                    <td><b><span id="user-modal-phone-number"></span></b></td>
                                </tr>
                                <tr>
                                    <td>Email Address:</td>
                                    <td><b><span id="user-modal-email"></span></b></td>
                                </tr>
                                <tr>
                                    <td width="150">Address:</td>
                                    <td><b><span id="user-modal-address"></span></b></td>
                                </tr>
                                <tr>
                                    <td>Date Joined:</td>
                                    <td><b><span id="user-modal-date-joined"></span></b></td>
                                </tr>
                                <tr>
                                    <td>Membership:</td>
                                    <td><b><span id="user-modal-membership"></span></b></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" id="user-role-btn">Add admin role</button>
                    <button type="button" class="btn btn-danger" id="user-delete-btn">Delete</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modified-script')
    <script type="text/javascript">


        //===================  USERS  ===================//


        var u_table = $('#users-table').DataTable({
            "resposive": true,
            "ajax": "{!! url('/') !!}/admin/ajax/users/get-all",
            "columns": [
                { "data": "name" },
                { "data": "email" },
                { "data": "date_joined" },
                { "data": "membership" },
                { "data": "id"}
            ],
            "columnDefs": [
                {
                    "targets": [0, 1],
                    "width": "15%",
                },
                {
                    "targets": [2],
                    "width": "20%",
                },
                {
                    "targets": [3],
                    "width": "5%",
                },
                {
                    "targets": [ 4 ],
                    "visible": false,
                    "searchable": false
                }
            ],
            "order": [[3, 'asc']],
            "createdRow": function(row, data, dataIndex) {
                //console.log(data)
                $(row).attr("onclick", "toggleUserModal("+data.id+")");
            },
        }).columns.adjust().draw();

        function toggleUserModal(id){
            $.ajax({
                url: "{!! url('/') !!}/admin/ajax/users/get-info/"+id,
                dataType: 'json',
                delay: 250,
                data: {
                    'id': id
                },
                success: function (data) {
                    $('#user-modal-profile-picture').html(data[0].profile_picture);
                    $('#user-modal-name').html(data[0].name);
                    $('#user-modal-birthday-age').html(data[0].birthday_age);
                    $('#user-modal-phone-number').html(data[0].phone_number);
                    $('#user-modal-email').html(data[0].email);
                    $('#user-modal-address').html(data[0].address);
                    $('#user-modal-date-joined').html(data[0].date_joined);
                    $('#user-modal-membership').html(data[0].membership);
                    if ({!! Auth::user()->id !!} != data[0].id) {
                        $('#user-role-btn').show();
                        if (data[0].is_admin == true) {
                            $('#user-role-btn').html("Remove admin role");
                            $('#user-role-btn').removeClass("btn-success");
                            $('#user-role-btn').addClass("btn-danger");
                            $('#user-role-btn').attr('onclick', 'removeAdminRole('+id+', \''+data[0].name+'\')');
                        }
                        else {
                            $('#user-role-btn').html("Add admin role");
                            $('#user-role-btn').removeClass("btn-danger");
                            $('#user-role-btn').addClass("btn-success");
                            $('#user-role-btn').attr('onclick', 'addAdminRole('+id+', \''+data[0].name+'\')');
                        }
                        $('#user-delete-btn').show();
                        $('#user-delete-btn').attr('onclick', 'deleteUser('+id+', \''+data[0].name+'\')');
                    }
                    else {
                        $('#user-role-btn').hide();
                        $('#user-delete-btn').hide();
                    }
                    
                },
                error: function (jqXHR, exception) {
                    console.log(exception);
                },
                cache: true
            });
            $("#user-modal").modal("toggle");
        }

        function removeAdminRole(id, name) {
            //loading -> success -> error -> swal -> table reload
            swal({
                title: "Are you sure?",
                type: "info",
                html: "Are you sure you want to remove the admin role of "+name+"?",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "No",
                confirmButtonText: "Yes"
            }).then(function() {
                $.ajax({
                    url: "{!! url('/') !!}/admin/ajax/users/remove-admin-role/"+id,
                    delay: 250,
                    data: {
                        'id': id
                    },
                    beforeSend: function () {
                        $('#user-role-btn').html('<i class="fa fa-spinner"></i> Loading...');
                    },
                    success: function (data) {
                        //alert(data);
                        //console.log(data);
                        //console.log(data);
                        $('#user-role-btn').html('Remove admin role');
                        $("#user-modal").modal("toggle");
                        if (data == "success") {
                            swal({
                                title: "Success",
                                type: "success",
                                html: "<div class=\"swal-success-status\">The admin role of "+name+" has been removed.</div>"
                            });
                        }
                        else {
                            swal({
                                title: "Error",
                                type: "error",
                                html: "<div class=\"swal-success-status\">Something went wrong, please try again later.</div>"
                            });
                        }
                        u_table.ajax.reload();
                        
                    },
                    error: function (jqXHR, exception) {
                        console.log(exception);
                    },
                    cache: true
                });
            });
                
            
        }

        function addAdminRole(id, name) {
            swal({
                title: "Are you sure?",
                type: "info",
                html: "Are you sure you want to add an admin role to "+name+"?",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "No",
                confirmButtonText: "Yes"
            }).then(function() {
                $.ajax({
                    url: "{!! url('/') !!}/admin/ajax/users/add-admin-role/"+id,
                    delay: 250,
                    data: {
                        'id': id
                    },
                    beforeSend: function () {
                        $('#user-role-btn').html('<i class="fa fa-spinner"></i> Loading...');
                    },
                    success: function (data) {
                        //alert(data);
                        //console.log(data);
                        //console.log(data);
                        $('#user-role-btn').html('Add admin role');
                        $("#user-modal").modal("toggle");
                        if (data == "success") {
                            swal({
                                title: "Success",
                                type: "success",
                                html: "<div class=\"swal-success-status\">The admin role has been added to "+name+".</div>"
                            });
                        }
                        else {
                            swal({
                                title: "Error",
                                type: "error",
                                html: "<div class=\"swal-success-status\">Something went wrong, please try again later.</div>"
                            });
                        }
                        u_table.ajax.reload();
                        
                    },
                    error: function (jqXHR, exception) {
                        console.log(exception);
                    },
                    cache: true
                });
            });
        }

        function deleteUser(id, name) {
            swal({
                title: "Are you sure?",
                type: "info",
                html: "Are you sure you want to delete the user : "+name+"?",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "No",
                confirmButtonText: "Yes"
            }).then(function() {
                $.ajax({
                    url: "{!! url('/') !!}/admin/ajax/users/delete/"+id,
                    delay: 250,
                    data: {
                        'id': id
                    },
                    beforeSend: function () {
                        $('#user-delete-btn').html('<i class="fa fa-spinner"></i> Loading...');
                    },
                    success: function (data) {
                        //alert(data);
                        //console.log(data);
                        //console.log(data);
                        $('#user-delete-btn').html('Delete');
                        $("#user-modal").modal("toggle");
                        if (data == "success") {
                            swal({
                                title: "Success",
                                type: "success",
                                html: "<div class=\"swal-success-status\">The user : "+name+", has been successfully deleted.</div>"
                            });
                        }
                        else {
                            swal({
                                title: "Error",
                                type: "error",
                                html: "<div class=\"swal-success-status\">Something went wrong, please try again later.</div>"
                            });
                        }
                        u_table.ajax.reload();
                        
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