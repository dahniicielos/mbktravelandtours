@extends('admin.master')

@section('title', 'ADMIN - Edit Blog')

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
            <?php
                function file_upload_max_size() {
                  static $max_size = -1;

                  if ($max_size < 0) {
                    // Start with post_max_size.
                    $post_max_size = parse_size(ini_get('post_max_size'));
                    if ($post_max_size > 0) {
                      $max_size = $post_max_size;
                    }

                    // If upload_max_size is less, then reduce. Except if upload_max_size is
                    // zero, which indicates no limit.
                    $upload_max = parse_size(ini_get('upload_max_filesize'));
                    if ($upload_max > 0 && $upload_max < $max_size) {
                      $max_size = $upload_max;
                    }
                  }
                  return $max_size;
                }

                function parse_size($size) {
                  $unit = preg_replace('/[^bkmgtpezy]/i', '', $size); // Remove the non-unit characters from the size.
                  $size = preg_replace('/[^0-9\.]/', '', $size); // Remove the non-numeric characters from the size.
                  if ($unit) {
                    // Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
                    return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
                  }
                  else {
                    return round($size);
                  }
                }

                function formatBytes($size, $precision = 2)
                {
                    $base = log($size, 1024);
                    $suffixes = array('', 'KB', 'MB', 'GB', 'TB');   

                    return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
                }
            ?>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
                    <a href="{!! url('/') !!}/admin/blogs" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Blogs</a >
                </div>
            </div>
            <div class="row" id="main">

                <!--
                    Open a form
                        /category dropdown
                        /title
                        /slug
                        /content
                        /meta keys
                        /meta description
                        featured img
                    close a form
                -->
                <div class="col">
                    <div class="card white card-light">
                        {!! Form::open(['id' => 'edit-blog', 'data-toggle' => 'validator', 'role' => 'form', 'files' => 'true']) !!}
                        <div class="head">
                            <h6 class="text-blue-dark" id="title">Write A New Blog</h6>
                            <hr>
                        </div>
                        <div class="body">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        {!! Form::label('title', 'TITLE', ['class' => 'form-label']) !!}
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
                                                {!! Form::text('title', $post->title,['class' => 'form-control', 'id' => 'post-title', 'required' => 'required', 'placeholder' => 'Enter Title here']) !!}
                                            </div>
                                        </div>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        {!! Form::label('slug', 'SLUG', ['class' => 'form-label']) !!} <i class="fa fa-question-circle info" data-toggle="popover" title="What is slug?" data-content="It is the page URL. You need this in order for the google to rank your page so you should make it readable to people as humanly possible." data-placement="bottom"></i>
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
                                                <div class="input-group">
                                                <div class="input-group-addon"><small>{!! url('/') !!}/blog/</small></div>
                                                {!! Form::text('slug', $post->slug,['class' => 'form-control', 'id' => 'slug', 'required' => 'required']) !!}
                                            </div>
                                            </div>
                                        </div>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        {!! Form::label('category', 'CATEGORY', ['class' => 'form-label']) !!}
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
                                                {!! Form::select('category', $categories, $post->category_id, ['class' => 'form-control', 'id' => 'category', 'required' => 'required']) !!}
                                            </div>
                                        </div>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <textarea id="summernote" name="content">{!! $post->content !!}</textarea>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        {!! Form::label('meta_description', 'META DESCRIPTION', ['class' => 'form-label']) !!} <br><i><small>This is what can be seen in the search engine search results, so in order for the searcher to click on your link, you should put a click-bait or something related. <b class="text-blue">Maximum of 160 characters.</b class="text-blue"></small></i>
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
                                                {!! Form::textarea('meta_description', $post->meta_description,['class' => 'form-control', 'id' => 'meta_description', 'required' => 'required', 'maxlength' => 160]) !!}
                                            </div>
                                        </div>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        {!! Form::label('meta_keys', 'META KEYS', ['class' => 'form-label']) !!} <br><i><small>This is where google is basing their primary search, if it matches the searcher's keyword to your page's meta keys. <b class="text-blue">Keywords should be separated by commas.</b class="text-blue"></small></i>
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
                                                {!! Form::textarea('meta_keys', $post->meta_keys, ['class' => 'form-control', 'id' => 'meta_keys', 'required' => 'required']) !!}
                                            </div>
                                        </div>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <i>This is what can be seen in the grid of blogs and in the header.</i>
                                        <br>
                                        <b class="text-blue">The accepted file types are images with a maximum of 
                                        {!! formatBytes(parse_size(file_upload_max_size()), 0) !!} in file size;</b>
                                        <img src="{!! $media->src !!}">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
                                                {!! Form::file('featured_img') !!}
                                            </div>
                                        </div>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <button class="btn btn-primary pull-right">Save</button>
                                    <a href="{!! url('/') !!}/admim/blogs" class="btn btn-default pull-right" style="margin-right: 5px;">Cancel</a>
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
        $(document).ready(function(){
            $("#summernote").summernote({
                minHeight: 400,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline']],
                    ['font', ['superscript', 'subscript']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['picture','video','link','table','hr']],
                    ['misc', 'redo','undo','fullscreen','help']
                ],
                popover: {}
            });
            $('.info').popover({});
            $("#post-title").on('keyup', function (e) {
                if($("#post-title").val() == ""){
                    $("#slug").val("");
                }
                else{
                    var input = $("#post-title").val().toLowerCase();
                    input = input.replace(/\W+/g, '-');
                    $("#slug").val(input);
                }
            });
        });
    </script>
@endsection