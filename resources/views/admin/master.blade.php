<?php
    if (!empty($_COOKIE['for]'])) {
        setcookie('for', '', time() - (86400 * 30), "/");
    }
    
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">

    <title> @yield('title') </title>

    <link rel="stylesheet" type="text/css" href="{!! url('/') !!}/assets/admin/css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{!! url('/') !!}/assets/admin/fonts/font_awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="{!! url('/') !!}/assets/admin/css/datatables/datatables.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.10/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="{!! url('/') !!}/assets/admin/summernote/dist/summernote.css">
    <link rel="stylesheet" type="text/css" href="{!! url('/') !!}/assets/admin/css/style.css">

    

     @yield('modified-style')

</head>
<body>
@include('admin.shared.loader')
<!-- start container fluid -->
<div id="container" class="container-fluid">
    <!-- start wrapper -->
    <div class="wrapper">
        <?php
            if (!isset($homepage)) {
                $homepage = DB::table('homepage')->first();
            }
            if (!isset($total_pending_inquiries)) {
                $total_pending_inquiries = 0;
                $custom_tour = DB::table('custom_tour_packages')->where('remark', 0)->count();
                $flight_reservation = DB::table('flight_inquiries')->where('remark', 0)->count();
                $hotel_reservation = DB::table('hotel_reservation_inquiries')->where('remark', 0)->count();
                $bus_booking = DB::table('bus_inquiries')->where('remark', 0)->count();
                $van_rental = DB::table('van_rental_inquiries')->where('remark', 0)->count();
                $total_pending_inquiries += $custom_tour + $flight_reservation + $hotel_reservation + $bus_booking + $van_rental;
            }
            if (!isset($total_pending_tour_clients)) {
                $total_pending_tour_clients = DB::table('purchases')->where('purchase_status', '!=', 2)->count();
            }
            if (!isset($total_pending_testimonials)) {
                $total_pending_testimonials = DB::table('testimonials')->where('remark', 0)->count();
            }
            if (!isset($total_pending_messages)) {
                $total_pending_messages = 0;
            }
            if (!isset($total_ads)) {
                $total_ads = 0;
            }
        ?>

        @include('admin.shared.sidebar')

        @yield('content')
        

    </div>
    <!-- end wrapper -->
</div>
<!-- end container fluid -->
<script type="text/javascript" src="{!! url('/') !!}/assets/admin/js/jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="{!! url('/') !!}/assets/admin/js/popper/umd/popper.js"></script>
<script type="text/javascript" src="{!! url('/') !!}/assets/admin/js/bootstrap/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.6.8-fix/jquery.nicescroll.min.js"></script>
<script type="text/javascript" src="{!! url('/') !!}/assets/admin/js/validator.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.10/sweetalert2.min.js"></script>
<script type="text/javascript" src="{!! url('/') !!}/assets/admin/summernote/dist/summernote.js"></script>
<script type="text/javascript" src="{!! url('/') !!}/assets/admin/js/script.js"></script>
@yield('modified-script')
<script type="text/javascript">
    var errors = '';
    @foreach ($errors->all() as $error)
        errors += '<li>{{ $error }}'+'</li>';
    @endforeach
    
    if (errors.length > 0) {
        swal({
            title: "Error!",
            type: "error",
            html: '<div class="swal-errors text-left" ><ul>'+errors+'</ul></div>'
        });
    }
    else {
        @if (session('status'))
            swal({
                title: "Success!",
                type: "success",
                html: "<div class=\"swal-success-status\">{{ session('status') }}</div>"
            });
        @elseif (session('error'))
            swal({
                title: "Error!",
                type: "error",
                html: "<div class=\"swal-error-status\">{{ session('error') }}</div>"
            });
        @endif
    }
    
</script>
</script>
</body>
</html>