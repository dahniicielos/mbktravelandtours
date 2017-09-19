<?php $__env->startSection('meta-description', 'A Travel and Tour Agency based in Naga City, Camarines Sur, Philippines'); ?>
<?php $__env->startSection('meta-keywords', 'travel, travels, tour, tours, naga, camarines, sur, mbk, madya, biyahe, kita'); ?>

<?php $__env->startSection('modified-style'); ?>
<style type="text/css">
        #tour-package-form-container{
            position: absolute;
            float: left;
            width: 100%;
            bottom: 0px;
        }

        #tour-package-form-card{
            position: relative;
            float: left;
            width: 80%;
            margin: 0px 10%;
        }

        #tour-package-form-header{
            position: absolute;
            float: left;
            width: 16%;
            height: 100%;
            padding: 0px 20px;
        }

        #vertical-align{
            position: absolute;
            top: 35%;
        }

        #tour-package-form-body{
            position: relative;
            float: left;
            width: 74%;
            margin-left: 16%;
        }

        #tour-package-form-container h4{
            margin: 0px;
        }

        #tour-package-form label{
            font-size: 11px;
            letter-spacing: 2px;
        }

        #tour-package-form-footer{
            position: absolute;
            float: left;
            width: 10%;
            height: 100%;
            right: 0px;
            cursor: pointer;
        }

        #tour-package-form-footer i{
            position: absolute;
            left: 40%;
            top: 40%;
            font-size: 25px;
        }

        #tour-packages-container{
            position: relative;
            float: left;
            width: 100%;
            height: 100vh;
        }

        .tour-background{
            position: absolute;
            float: left;
            width: 100%;
            height: 100%;
            z-index: -99;
            -webkit-transition: opacity 1s ease-in-out;
            -moz-transition: opacity 1s ease-in-out;
            -o-transition: opacity 1s ease-in-out;
            transition: opacity 1s ease-in-out;
            opacity:0;
            -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
            filter: alpha(opacity=0);
        }

        .tour-background.active{
            opacity: 1;
            -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
            filter: alpha(opacity=1);
        }

        #tab-container{
            position: relative;
            float: left;
            width: 100%;
            margin-top: 100px;
        }

        .nav-pills > li{
            width: calc(50% - 1px);
            text-align: center;
        }

        .nav-pills > li > a{
            color: #FFFFFF;
            transition: all 0.1s ease-in;
        }

        .nav > li > a:focus,
        .nav > li > a:hover{
            background-color: transparent;
        }

        .nav-pills > li.active > a,
        .nav-pills > li.active > a:focus,
        .nav-pills > li.active > a:hover{
            background-color: transparent;
            border-bottom: 3px solid #FFFFFF;
            border-radius: 0px;
        }

        #swipers{
            position: absolute;
            float: left;
            bottom: 20px;
            width: 100%;
        }

        .swiper-container {
            width: 55%;
            height: 300px;
        }

        .swiper-slide{
            background-color: #FFFFFF;
            height: 85%;
            cursor: pointer;
        }

        .swiper-fill{
            position: relative;
            float: left;
            width: 100%;
            height: 100%;
        }

        .tour-info{
            position: absolute;
            float: left;
            width: 100%;
            background: rgba(0, 0, 0, 0.7);
            bottom: 0px;
        }

        .tour-info p{
            margin: 15px;
        }

        .tour-info .tour-btn{
            margin: 0px;
            padding: 10px 15px;
            font-size: 12px;
        }

        .tour-info p small{
            font-size: 11px;
        }

        .swiper-pagination-bullet-active{
            background: #FFFFFF;
        }

        .thumbnail p{
            font-size: 11px;
        }

        #promo-container{
            background: url('assets/images/promo_background.jpg') center no-repeat;
            background-size: cover;
            background-attachment: fixed;
            padding: 0px;
        }

        #promo-container .fill{
            padding: 100px 0px 85px 0px;
        }

        #promo-title{
            font-size: 50px;
            margin: 0px 0px 20px 0px;
        }

        #logo-swiper{
            width: 100%;
            height: 125px;
        }

        #logo-swiper img{
            height: 100%;
        }

        #newsletter p{
            margin: 30px 0px;
            letter-spacing: 2px;
            font-size: 15px;
        }

        #newsletter p i{
            margin-right: 20px;
        }

        #newsletter .form-control{
            height: 55px;
            margin-top: 12px;
            padding-left: 20px;
        }

        .ad_image{
            content: url('<?php echo url('/'); ?>/assets/images/ads/ad_landscape.jpg');
        }

        .empty-tour-package{
            margin-bottom: 20%;
        }

        /* small laptop */
        @media(max-width: 1024px){
            #tour-package-form-card{
                width: 95%;
                margin: 0px 2.5%;
            }
        }

        /* tablet */
        @media (max-width: 768px) and (min-width: 426px){
            #tour-package-form-card{
                width: 100%;
                margin: 0px;
            }

            #tour-package-form-header{
                padding: 0px 10px;
            }

            #tour-package-form-container h4{
                font-size: 15px;
            }

            #tour-package-form-header small{
                font-size: 9px;
            }

            #tour-package-form-footer i{
                left: 35%;
                top: 43%;
                font-size: 20px;
            }

            .swiper-container{
                width: 90%;
            }

            .empty-tour-package{
                margin-bottom: 55%;
            }
        }

        /* mobile */
        @media (max-width: 425px){
            #tour-package-form-container{
                position: relative;
                float: left;
                width: 100%;
                margin-top: 160px;
            }

            #tour-package-form-card{
                position: relative;
                float: left;
                width: 100%;
                margin: 0px;
            }

            #tour-package-form-header{
                position: relative;
                float: left;
                width: 100%;
                height: auto;
                padding: 15px;
            }

            #vertical-align{
                position: relative;
                top: 0px;
            }

            #tour-package-form-body{
                position: relative;
                float: left;
                width: 100%;
                margin: 0px;
            }

            #tour-package-form-container .form-group{
                margin-bottom: 0px;
            }

            #tour-package-form-footer{
                position: relative;
                float: left;
                width: 100%;
                height: auto;
                padding: 20px 0px;
                margin-top: 15px;
            }

            #tour-package-form-footer i{
                position: relative;
                left: 0;
                top: 0;
            }

            #tour-package-tab-container{
                padding: 10px;
            }

            .nav-pills > li{
                width: 49%;
            }

            .swiper-container{
                width: 95%;
            }

            #promo-title{
                font-size: 40px;
                width: 90%;
                margin: 0 5%;
                margin-bottom: 20px;
            }

            #promo-desc{
                width: 90%;
                margin: 0 5%;
                font-size: 12px;
            }

            #newsletter p{
                font-size: 12px;
                text-align: center;
                margin-bottom: 10px;
            }

            #newsletter .form-group{
                margin-bottom: 0px;
            }

            #newsletter-btn{
                text-align: center;
            }

            .ad_image{
                content: url('<?php echo url('/'); ?>/assets/images/ads/ad_landscape_two.jpg');
            }

            .empty-tour-package{
                margin-bottom: 55%;
                margin-left: 30px;
                margin-right: 30px;
            }
        }

    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('title', 'MBK Travel and Tours'); ?>

<?php $__env->startSection('content'); ?>

    <!-- Header -->
    <div class="jumbotron">
        <div class="fill text-center">
            <h1 id="title" class="text-white text-center">Madya Biyahe Kita!</h1>
            <p id="subtitle" class="text-white text-center">Travel &amp; Tours Agency</p>
            <?php if(!Auth::check()): ?>
                <a href="<?php echo url('/'); ?>/users/login" class="btn btn-primary text-uppercase">Sign In</a>
                <a href="<?php echo url('/'); ?>/users/register" class="btn btn-default text-uppercase text-blue">Sign Up</a>
            <?php endif; ?>
        </div>
        <div id="tour-package-form-container">
            <?php echo Form::open(['action' => 'TourPackageController@index', 'method' => 'get', 'id' => 'tour-package-form']); ?>

                <div id="tour-package-form-card" class="bg-white">
                    <div id="tour-package-form-header" class="bg-blue">
                        <div id="vertical-align">
                            <h4 class="text-white text-uppercase">Find A Tour</h4>
                            <small class="text-white">Plan your trip with us</small>
                        </div>
                    </div>
                    <div id="tour-package-form-body">
                        <div class="row" style="padding:20px 15px">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <div class="form-group">
                                    <?php echo Form::label('keyword', 'Destination', ['class' => 'text-uppercase']); ?>

                                    <?php echo Form::text('keyword[]', '', ['class' => 'form-control', 'id' => 'keyword', 'placeholder' => 'Enter Destination']); ?>

                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <div class="form-group">
                                    <?php echo Form::label('travel_date', 'Travel Date', ['class' => 'text-uppercase']); ?>

                                    <?php echo Form::text('travel_date[]', '', ['class' => 'form-control', 'id' => 'travel-date', 'placeholder' => 'Pick a date', 'onkeydown' => 'return false']); ?>

                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                <div class="form-group">
                                    <?php echo Form::label('duration', 'Duration', ['class' => 'text-uppercase']); ?>

                                    <?php echo Form::number('duration[]', '', ['class' => 'form-control', 'id' => 'duration', 'placeholder' => 'Enter no. of days', 'min' => '1']); ?>

                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                <div class="form-group">
                                    <?php echo Form::label('guest', 'Guest', ['class' => 'text-uppercase']); ?>

                                    <?php echo Form::number('guest[]', '', ['class' => 'form-control', 'id' => 'guest', 'placeholder' => 'No. of PAX', 'min' => '1']); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" id="tour-package-form-footer" class="bg-blue text-center" style="border-color: #2196F3 !important">
                        <i class="fa fa-search text-white"></i>
                    </button>
                </div>
            <?php echo Form::close(); ?>

        </div>
        
    </div>
    <!-- Header -->


    <!-- About -->
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1 col-md-12 col-sm-12 col-xs-12 text-center box" style="padding-bottom: 0px;">
            <h2 class="title text-uppercase text-blue">About Us</h2>
            <p class="text-center content">
                <?php echo $homepage->about; ?>

            </p>
        </div>
    </div>
    <!-- About -->

    <!-- Services -->
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1 col-md-12 col-sm-12 col-xs-12 text-center box">
            <h2 class="title text-uppercase text-blue">Services</h2>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-left">
                    <?php $counter = 0; ?>
                    <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($counter % 2 == 0): ?>
                            <div class="media">
                                <div class="media-left">
                                    <a href="<?php echo url('/'); ?><?php echo $service->service_link; ?>">
                                        <img src="<?php echo url('/'); ?>/assets/images/<?php echo $service->icon; ?>" class="media-object">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <a href="<?php echo url('/'); ?><?php echo $service->service_link; ?>">
                                        <h4 class="media-heading">
                                            <?php echo $service->name; ?>

                                        </h4>
                                    </a>
                                    <p>
                                        <?php echo $service->description; ?>

                                    </p>
                                </div>
                            </div>
                            <?php $counter++; ?>
                        <?php else: ?>
                            <?php $counter++; ?>
                            <?php continue; ?>
                        <?php endif; ?>
                            
                        
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-left">
                    <?php $counter = 0; ?>
                    <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($counter % 2 != 0): ?>
                            <div class="media">
                                <div class="media-left">
                                    <a href="<?php echo url('/'); ?><?php echo $service->service_link; ?>">
                                        <img src="<?php echo url('/'); ?>/assets/images/<?php echo $service->icon; ?>" class="media-object">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <a href="<?php echo url('/'); ?><?php echo $service->service_link; ?>">
                                        <h4 class="media-heading">
                                            <?php echo $service->name; ?>

                                        </h4>
                                    </a>
                                    <p>
                                        <?php echo $service->description; ?>

                                    </p>
                                </div>
                            </div>
                            <?php $counter++; ?>
                        <?php else: ?>
                            <?php $counter++; ?>
                            <?php continue; ?>
                        <?php endif; ?>
                            
                        
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Services -->

    <?php echo $__env->make('shared.ad_space', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <!-- Tour Packages -->
    <div class="row">
        <div id="tour-packages-container">
            <?php $counter = 1; ?>
            <?php $__currentLoopData = $international_tour_packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $international_tour_package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="tour-background 
                <?php if($counter == 1): ?>
                    active
                <?php endif; ?>
                " id="<?php echo $international_tour_package->slug; ?>" style="background: url('<?php echo url('/'); ?>/assets/images/<?php echo $international_tour_package->package_image; ?>') center no-repeat; background-size: cover; background-attachment: fixed;"></div>
                <?php $counter++; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php $counter = 1; ?>
            <?php $__currentLoopData = $local_tour_packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $local_tour_package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="tour-background 
                <?php if($counter == 1): ?>
                    active
                <?php endif; ?>
                " id="<?php echo $local_tour_package->slug; ?>" style="background: url('<?php echo url('/'); ?>/assets/images/<?php echo $local_tour_package->package_image; ?>') center no-repeat; background-size: cover; background-attachment: fixed;"></div>
                <?php $counter++; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
            <div class="fill">
                <div class="row">
                    <div class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-12" id="tour-package-tab-container">
                        <div id="tab-container">
                            <ul class="nav nav-pills" role="tablist">
                                <li role="presentation" class="active"><a class="text-uppercase" href="#international" aria-controls="international" data-toggle="pill">International</a></li>
                                <li role="presentation"><a class="text-uppercase" href="#local" aria-controls="local" data-toggle="pill">Local</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="swipers">
                    <div class="tab-content">
                        <div class="tab-pane active" role="tabpanel" id="international">
                            <?php if($international_tour_packages->isEmpty()): ?>
                                <p class="text-center text-white empty-tour-package">Sorry, there's no available international tour package at this moment</p>
                            <?php else: ?>
                                <?php $counter = 1; ?>
                                <div class="swiper-container" id="international-swiper">
                                    <div class="swiper-wrapper">
                                        <?php $__currentLoopData = $international_tour_packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $international_tour_package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="swiper-slide">
                                                <div class="swiper-fill" style="background: url('<?php echo url('/'); ?>/assets/images/<?php echo $international_tour_package->package_image; ?>') center no-repeat; background-size: cover;" onmouseover="changeBackground('#<?php echo $international_tour_package->slug; ?>')">
                                                    <div class="tour-info">
                                                        <p class="text-white">
                                                            <?php echo $international_tour_package->name; ?><br>
                                                            <small class="text-white">
                                                                <?php echo $international_tour_package->no_of_days; ?> days &amp; <?php echo $international_tour_package->no_of_nights; ?> nights<br>
                                                                Starts at ₱ <?php echo number_format($international_tour_package->price_starts, 2, '.', ','); ?>

                                                            </small>
                                                        </p>
                                                        <p class="tour-btn bg-white"><a href="<?php echo url('/'); ?>/tour-packages/<?php echo $international_tour_package->slug; ?>" >View Full Package Details</a></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $counter++; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                    <div class="swiper-pagination"></div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="tab-pane" role="tabpanel" id="local">
                            <?php if($local_tour_packages->isEmpty()): ?>
                                <p class="text-center text-white empty-tour-package">Sorry, there's no available local tour package at this moment</p>
                            <?php else: ?>
                                <?php $counter = 1; ?>
                                <div class="swiper-container" id="local-swiper">
                                    <div class="swiper-wrapper">
                                        <?php $__currentLoopData = $local_tour_packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $local_tour_package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="swiper-slide">
                                                <div class="swiper-fill" style="background: url('<?php echo url('/'); ?>/assets/images/<?php echo $local_tour_package->package_image; ?>') center no-repeat; background-size: cover;" onmouseover="changeBackground('#<?php echo $local_tour_package->slug; ?>')">
                                                    <div class="tour-info">
                                                        <p class="text-white">
                                                            <?php echo $local_tour_package->name; ?><br>
                                                            <small class="text-white">
                                                                <?php echo $local_tour_package->no_of_days; ?> days &amp; <?php echo $local_tour_package->no_of_nights; ?> nights<br>
                                                                Starts at ₱ <?php echo number_format($local_tour_package->price_starts, 2, '.', ','); ?>

                                                            </small>
                                                        </p>
                                                        <p class="tour-btn bg-white"><a href="<?php echo url('/'); ?>/tour-packages/<?php echo $local_tour_package->slug; ?>" >View Full Package Details</a></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $counter++; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                    <div class="swiper-pagination"></div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Tour Packages -->

    <!-- Blog -->
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-12 col-xs-12 text-center box">
            <h2 class="title text-uppercase text-blue">Blog</h2>
            
                <?php if($blogs->isEmpty()): ?>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                        <h4 class="text-blue">
                            Sorry, there is no available blog post for now.
                        </h4>
                    </div>
                <?php else: ?>
                    <div class="row row-centered">
                    <?php $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-centered col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="thumbnail">
                                <a href="<?php echo url('/'); ?>/blog/<?php echo $blog->slug; ?>"><img src="<?php echo $blog->src; ?>"></a>
                                <div class="caption text-left">
                                    <a href="<?php echo url('/'); ?>/blog/<?php echo $blog->slug; ?>"><h4 class="text-blue"><?php echo $blog->title; ?></h4></a>
                                    <p>
                                        <?php
                                            $pos=strpos($blog->content, ' ', 160); 
                                        ?>
                                        <?php echo substr($blog->content, 0, $pos); ?>...
                                    </p>
                                    <p class="text-gray"> <?php echo date("F j, Y", strtotime($blog->date_published)); ?> <span class="pull-right"><i class="fa fa-comment"></i> 2</span></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                            <a href="<?php echo url('/'); ?>/blogs" class="btn btn-primary text-uppercase">Read More</a>
                        </div>
                    </div>
                <?php endif; ?>

            
        </div>
    </div>
    <!-- Blog -->

    

    <?php echo $__env->make('shared.ad_space', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('shared.promo', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('shared.airline_partners', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('shared.newsletter', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('modified-script'); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>