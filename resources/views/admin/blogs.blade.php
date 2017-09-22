@extends('admin.master')

@section('title', 'ADMIN - Blogs')

@section('modified-style')
    <style type="text/css">
        .card{
            margin: 10px 0px 20px 0px;
        }

        #main{
            margin-top: 20px;
        }

        #main .card{
            padding: 0px;
        }

        #main .card img{
            width: 100%;
        }

        #main .card p{
            font-size: 12px;
        }

        .nav .badge{
            margin-left: 5px;
        }
    </style>
@endsection

@section('content')
    <!-- Page Content Holder -->
    <div id="content" class="bg-light-gray">
        <!-- <nav class="navbar navbar-default">
            <div class="container-fluid">

                <div class="navbar-header">
                    <button type="button" id="sidebarCollapse" class="btn btn-info navbar-btn">
                        <i class="glyphicon glyphicon-align-left"></i>
                        <span>Toggle Sidebar</span>
                    </button>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#">Page</a></li>
                        <li><a href="#">Page</a></li>
                        <li><a href="#">Page</a></li>
                        <li><a href="#">Page</a></li>
                    </ul>
                </div>
            </div>
        </nav> -->
        <div class="row">
            <div class="col"><p>Blogs</p></div>
            <div class="col text-right"><a href="{!! url('/') !!}/admin/blogs/new" class="btn btn-primary">Write A New Blog</a></div>
        </div>
        <div class="row" id="main">
            <div class="col">
                <ul class="nav nav-pills" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="all-tab" data-toggle="tab" href="#all" role="tab" aria-controls="all" aria-expanded="true">All <span class="badge badge-danger">{!! count($posts) !!}</span></a>
                    </li>
                    @foreach ($categories as $category)
                        <li class="nav-item">
                            <a class="nav-link" id="{!! $category->name !!}-tab" data-toggle="tab" href="#{!! $category->name !!}" role="tab" aria-controls="{!! $category->name !!}" aria-expanded="true">{!! $category->name !!} 
                                <?php
                                    $this_category_count = DB::table('posts')->where('category_id', $category->id)->count();
                                    if ($this_category_count > 0) {
                                        echo '<span class="badge badge-danger">';
                                        echo $this_category_count;
                                        echo '</span>';
                                    }
                                ?>
                            </a>
                        </li>
                    @endforeach
                    <li class="nav-item">
                        <a class="nav-link" id="others-tab" data-toggle="tab" href="#others" role="tab" aria-controls="all" aria-expanded="true">Others 
                            <?php
                                $others_count = DB::table('posts')->where('category_id', 0)->count();
                                if ($others_count > 0) {
                                    echo '<span class="badge badge-danger">';
                                    echo $others_count;
                                    echo '</span>';
                                }
                            ?>
                        </a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent" style="margin-top: 20px">
                    <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
                        <div class="row">
                            @foreach ($posts as $post)
                                <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                    <div class="card white card-light">
                                        <img src="{!! $post->src !!}">
                                        <div class="body">
                                            <a href="" class="text-blue-dark"><b>{!! $post->title !!}</b></a>
                                            <hr>
                                            <p>
                                                <?php
                                                    
                                                    if (strlen($post->content) >= 160) {
                                                        $pos=strpos($post->content, ' ', 160); 
                                                    }
                                                    else {
                                                        $pos = strlen($post->content);
                                                    }
                                                ?>
                                                
                                                {!! substr($post->content, 0, $pos) !!}...<br><br>
                                                <a href="{!! url('/') !!}/blog/{!! $post->slug !!}" class="btn btn-primary text-uppercase">View</a>
                                                <button class="btn btn-danger text-uppercase pull-right" onclick="deletePost({!! $post->id !!})">Delete</button>
                                                <a href="{!! url('/') !!}/admin/blogs/edit/{!! $post->id !!}" class="btn btn-default text-uppercase pull-right">Edit</a>
                                                
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @foreach($categories as $category)
                        <div class="tab-pane fade" id="{!! $category->name !!}" role="tabpanel" aria-labelledby="{!! $category->name !!}-tab">
                            <div class="row">
                                @foreach ($posts as $post)
                                    @if ($post->category_id == $category->id)
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                            <div class="card white card-light">
                                                <img src="{!! $post->src !!}">
                                                <div class="body">
                                                    <a href="" class="text-blue-dark"><b>{!! $post->title !!}</b></a>
                                                    <hr>
                                                    <p>
                                                        <?php
                        
                                                            if (strlen($post->content) >= 160) {
                                                                $pos=strpos($post->content, ' ', 160); 
                                                            }
                                                            else {
                                                                $pos = strlen($post->content);
                                                            }
                                                        ?>
                                                        
                                                        {!! substr($post->content, 0, $pos) !!}...<br><br>
                                                        <a href="{!! url('/') !!}/blog/{!! $post->slug !!}" class="btn btn-primary text-uppercase">View</a>
                                                        <button class="btn btn-danger text-uppercase pull-right" onclick="deletePost({!! $post->id !!})">Delete</button>
                                                        <a href="{!! url('/') !!}/admin/blogs/edit/{!! $post->id !!}" class="btn btn-default text-uppercase pull-right">Edit</a>
                                                        
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                    <div class="tab-pane fade" id="others" role="tabpanel" aria-labelledby="others-tab">
                        <div class="row">
                            @foreach ($posts as $post)
                                @if ($post->category_id == 0)
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div class="card white card-light">
                                            <img src="{!! $post->src !!}">
                                            <div class="body">
                                                <a href="" class="text-blue-dark"><b>{!! $post->title !!}</b></a>
                                                <hr>
                                                <p>
                                                    <?php
                    
                                                        if (strlen($post->content) >= 160) {
                                                            $pos=strpos($post->content, ' ', 160); 
                                                        }
                                                        else {
                                                            $pos = strlen($post->content);
                                                        }
                                                    ?>
                                                    
                                                    {!! substr($post->content, 0, $pos) !!}...<br><br>
                                                    <a href="{!! url('/') !!}/blog/{!! $post->slug !!}" class="btn btn-primary text-uppercase">View</a>
                                                    <button class="btn btn-danger text-uppercase pull-right" onclick="deletePost({!! $post->id !!})">Delete</button>
                                                    <a href="{!! url('/') !!}/admin/blogs/edit/{!! $post->id !!}" class="btn btn-default text-uppercase pull-right">Edit</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('modified-script')
    <script type="text/javascript">
        function deletePost(id) {
            swal({
                title: "Delete Post?",
                type: "info",
                html: "Are you sure you want to delete this post?",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "No",
                confirmButtonText: "Yes"
            }).then(function() {
                <?php

                    $link = url('/').'/admin/blogs/delete/';
                ?>
                window.location.href = '{!! $link !!}'+id;
            });
        }
    </script>
@endsection