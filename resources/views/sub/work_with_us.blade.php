@extends('master')

@section('meta-description', 'Careers of MBK, A Travel and Tour Agency based in Naga City, Camarines Sur, Philippines')
@section('meta-keywords', 'careers, work, with, us, travel, travels, tour, tours, naga, camarines, sur, mbk, madya, biyahe, kita')


@section('modified-style')
    <style type="text/css">
        #header{
            position: relative;
            float: left;
            width: 100%;
            height: 75vh;
            background: url('{!! url('/') !!}/assets/images/faqs_header.jpg') bottom no-repeat;
            background-size: cover;
            background-attachment: fixed;
        }

        #header h2{
            position: absolute;
            width: calc(100% - 140px);
            bottom: 50px;
            left: 70px;
            font-size: 45px;
        }

        #header .btn{
            margin: 3px 0px 0px 0px;
        }

        #content{
            position: relative;
            float: left;
            width: 100%;
            padding: 50px 70px;
        }

        ol li{
            padding: 15px 0px;
        }

        .footer{
            position: relative;
            float: left;
            width: 100%;
        }

        @media (max-width: 768px) and (min-width: 426px){
            #header h2{
                left: 20px;
                width: calc(100% - 40px);
            }

            #content{
                padding: 50px 15px;
            }
        }

        @media (max-width: 425px){
            #header h2{
                left: 20px;
                width: calc(100% - 40px);
            }

            #header h2 .btn{
                display: none;
            }

            #content{
                padding: 50px 15px;
            }
        }
    </style>
@endsection

@section('title')
    MBK - Work With Us
@endsection

@section('content')
    <!-- Header -->
    <div id="header">
        <div class="fill">
            <h2 class="text-white">Work With Us</h2>
        </div>
    </div>
    <!-- Header -->



    <!-- Content -->
    <div id="content">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                 {!! $sub->work_with_us !!}
                 <br><br>
                <h3>Contact Us</h3>
                <p>
                    Telephone number: <b>{!! $homepage->phone_number !!}</b><br>
                    Email Address: <b>{!! $homepage->email_address !!}</b>
                </p>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            </div>
        </div>
    </div>
    <!-- Content -->


@endsection