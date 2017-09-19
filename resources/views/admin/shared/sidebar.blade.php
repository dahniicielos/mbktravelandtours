<!-- Sidebar Holder -->
<nav id="sidebar" class="bg-gr-blue">
    <div class="sidebar-header">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-4 text-center"><img src="{!! Auth::user()->profile_picture !!}"></div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-8">
                <h6 class="text-white" style="margin-top: 5px; margin-bottom: 0px;">{!! ucwords(Auth::user()->first_name) !!} {!! ucwords(Auth::user()->last_name) !!}</h6>
                <small class="text-white" style="font-size: 11px">
                <?php
                    $roles = Auth::user()->roles;
                    $counter = 0;
                    foreach ($roles as $role) {
                        if ($counter > 0) {
                            echo ', ';
                        }
                        echo ucwords($role->name);
                        $counter++;
                    }
                ?>
                </small>
            </div>
        </div>
    </div>

    <ul class="list-unstyled components">
        <li><a href="{!! url('/') !!}">
            <i class="fa fa-globe"></i> Website
            </a>
        </li>
        <li class="
            <?php $this_url = url('/').'/admin/dashboard'; ?>
            @if(Request::url() === $this_url)
                active"><a style="cursor:default">
            @else
                "><a href="{!! url('/') !!}/admin/dashboard">
            @endif
            <i class="fa fa-home"></i> Dashboard
            @if ($total_pending_inquiries > 0)
                <span class="badge badge-danger pull-right">{!! $total_pending_inquiries !!}</span>
            @endif
            </a>
        </li>
        <li class="
            <?php $this_url = url('/').'/admin/tour-clients'; ?>
            @if(Request::url() === $this_url)
                active"><a style="cursor:default">
            @else
                "><a href="{!! url('/') !!}/admin/tour-clients">
            @endif
            <i class="fa fa-user"></i> Tour Clients
            @if ($total_pending_tour_clients > 0)
                <span class="badge badge-danger pull-right">{!! $total_pending_tour_clients !!}</span>
            @endif
            </a>
        </li>
        <li>
            <a href="{!! url('/') !!}/admin/messaging"><i class="fa fa-comments"></i> Live Chat 
                @if ($total_pending_messages > 0)
                    <span class="badge badge-danger pull-right">{!! $total_pending_messages !!}</span>
                @endif
            </a>
        </li>
        <li>
            <a href="{!! url('/') !!}/admin/tour-packages"><i class="fa fa-map"></i> Tour Packages</a>
        </li>
        <li class="
            <?php $this_url = url('/').'/admin/blogs'; ?>
            @if(Request::url() === $this_url)
                active"><a style="cursor:default">
            @else
                "><a href="{!! url('/') !!}/admin/blogs">
            @endif 
            <i class="fa fa-pencil"></i> Blogs</a>
        </li>
        <li class="
            <?php $this_url = url('/').'/admin/faqs'; ?>
            @if(Request::url() === $this_url)
                active"><a style="cursor:default">
            @else
                "><a href="{!! url('/') !!}/admin/faqs">
            @endif
            <i class="fa fa-question"></i> FAQs</a>
        </li>
        <li class="
            <?php $this_url = url('/').'/admin/testimonials'; ?>
            @if(Request::url() === $this_url)
                active"><a style="cursor:default">
            @else
                "><a href="{!! url('/') !!}/admin/testimonials">
            @endif
            <i class="fa fa-star"></i> Testimonials 
                @if ($total_pending_testimonials > 0)
                    <span class="badge badge-danger pull-right">{!! $total_pending_testimonials !!}</span>
                @endif
            </a>
        </li>
        <li>
            <a href="{!! url('/') !!}/admin/ads"><i class="fa fa-certificate"></i> Ads 
                @if ($total_ads > 0)
                    <span class="badge badge-danger pull-right">{!! $total_ads !!}</span>
                @endif
            </a>
        </li>
        <li class="
            <?php $this_url = url('/').'/admin/users'; ?>
            @if(Request::url() === $this_url)
                active"><a style="cursor:default">
            @else
                "><a href="{!! url('/') !!}/admin/users">
            @endif
            <i class="fa fa-users"></i> Users 
            </a>
        </li>
        <li class="
            <?php $this_url = url('/').'/admin/newsletter'; ?>
            @if(Request::url() === $this_url)
                active"><a style="cursor:default">
            @else
                "><a href="{!! url('/') !!}/admin/newsletter">
            @endif
            <i class="fa fa-envelope-o"></i> Newsletter 
            </a>
        </li>
        <li class="
            <?php $this_url = url('/').'/admin/settings'; ?>
            @if(Request::url() === $this_url)
                active"><a style="cursor:default">
            @else
                "><a href="{!! url('/') !!}/admin/settings">
            @endif
            <i class="fa fa-cog"></i> Settings 
            </a>
        </li>
        
        <li>
            <a href="#pages" data-toggle="collapse" aria-expanded="false"><i class="fa fa-file"></i> Pages</a>
            <?php 
                $this_url = array(
                    url('/').'/admin/pages/home', 
                    url('/').'/admin/pages/flight',
                    url('/').'/admin/pages/custom-tour',
                    url('/').'/admin/pages/bus',
                    url('/').'/admin/pages/hotel',
                    url('/').'/admin/pages/van',
                    url('/').'/admin/pages/hotel-policy',
                    url('/').'/admin/pages/flight-policy',
                    url('/').'/admin/pages/terms-and-conditions',
                    url('/').'/admin/pages/work-with-us',
                ); 
            ?>
            <ul class="collapse list-unstyled 
            @if(in_array(Request::url(), $this_url))
                show
            @endif
            " id="pages">
                <li
                    <?php $this_page_url = url('/').'/admin/pages/home' ?>
                    @if(Request::url() === $this_page_url)
                        class="active"
                    @endif
                ><a href="{!! $this_page_url !!}">Home Page</a></li>
                <li
                    <?php $this_page_url = url('/').'/admin/pages/flight' ?>
                    @if(Request::url() === $this_page_url)
                        class="active"
                    @endif
                ><a href="{!! $this_page_url !!}">Flight Page</a></li>
                <li
                    <?php $this_page_url = url('/').'/admin/pages/custom-tour' ?>
                    @if(Request::url() === $this_page_url)
                        class="active"
                    @endif
                ><a href="{!! $this_page_url !!}">Custom Tour Page</a></li>
                <li
                    <?php $this_page_url = url('/').'/admin/pages/bus' ?>
                    @if(Request::url() === $this_page_url)
                        class="active"
                    @endif
                ><a href="{!! $this_page_url !!}">Bus Page</a></li>
                <li
                    <?php $this_page_url = url('/').'/admin/pages/hotel' ?>
                    @if(Request::url() === $this_page_url)
                        class="active"
                    @endif
                ><a href="{!! $this_page_url !!}">Hotel Page</a></li>
                <li
                    <?php $this_page_url = url('/').'/admin/pages/van' ?>
                    @if(Request::url() === $this_page_url)
                        class="active"
                    @endif
                ><a href="{!! $this_page_url !!}">Van Page</a></li>
                <li
                    <?php $this_page_url = url('/').'/admin/pages/hotel-policy' ?>
                    @if(Request::url() === $this_page_url)
                        class="active"
                    @endif
                ><a href="{!! $this_page_url !!}">Hotel Policy Page</a></li>
                <li
                    <?php $this_page_url = url('/').'/admin/pages/flight-policy' ?>
                    @if(Request::url() === $this_page_url)
                        class="active"
                    @endif
                ><a href="{!! $this_page_url !!}">Flight Policy Page</a></li>
                <li
                    <?php $this_page_url = url('/').'/admin/pages/terms-and-conditions' ?>
                    @if(Request::url() === $this_page_url)
                        class="active"
                    @endif
                ><a href="{!! $this_page_url !!}">Terms and Conditions</a></li>
                <li
                    <?php $this_page_url = url('/').'/admin/pages/work-with-us' ?>
                    @if(Request::url() === $this_page_url)
                        class="active"
                    @endif
                ><a href="{!! $this_page_url !!}">Work With Us Page</a></li>
            </ul>
        </li>
        <!-- <li>
            <a href="#">About</a>
            <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false">Pages</a>
            <ul class="collapse list-unstyled" id="pageSubmenu">
                <li><a href="#">Page 1</a></li>
                <li><a href="#">Page 2</a></li>
                <li><a href="#">Page 3</a></li>
            </ul>
        </li>
        <li>
            <a href="#">Portfolio</a>
        </li>
        <li>
            <a href="#">Contact</a>
        </li> -->
    </ul>
</nav>

<div id="sidebar-toggle">
    <i class="fa fa-bars"></i>
</div>