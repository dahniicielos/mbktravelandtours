<?php

namespace App\Http\Controllers\Admin;

use Image;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Post;
use App\Category;
use App\Media;
use App\Http\Requests\BlogFormRequest;
use App\Http\Requests\EditBlogFormRequest;


class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::select('posts.id', 'posts.title', 'posts.content', 'posts.slug', 'posts.status', 'posts.author', 'posts.meta_description', 'posts.meta_keys', 'posts.date_published', 'posts.featured_img', 'posts.category_id', 'm.src')->leftJoin('medias as m', 'posts.featured_img', '=', 'm.id')->orderBy('posts.date_published', 'desc')->get();
        $categories = Category::all();
        //if category == 0 : category == "others"
        return view('admin.blogs', compact('posts', 'categories'));
    }

    public function add_new_post()
    {
        $categories = Category::pluck('name', 'id');
        $categories[0] = "Others";
        return view('admin.new_blog', compact('categories'));
    }

    public function save_new_post(BlogFormRequest $request)
    {
        $title = $request->get('title');
        $content = $request->get('content');//this is the one with the message

        $dom = new \DOMDocument();
        $dom->loadHtml($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);    
        $images = $dom->getElementsByTagName('img');
       // foreach <img> in the submited message
        foreach($images as $img){
            $src = $img->getAttribute('src');
            
            // if the img source is 'data-url'
            if(preg_match('/data:image/', $src)){                
                // get the mimetype
                preg_match('/data:image\/(?<mime>.*?)\;/', $src, $groups);
                $mimetype = $groups['mime'];                
                // Generating a random filename
                $filename = uniqid();
                $filepath = "/assets/images/summernoteimages/$filename.$mimetype";
                //$filepath = "/summernoteimages/$filename.$mimetype";    
                // @see http://image.intervention.io/api/
                $image = Image::make($src)
                  // resize if required
                  /* ->resize(300, 200) */
                  ->encode($mimetype, 100)  // encode file to the specified mimetype
                  ->save(public_path($filepath));                
                $new_src = asset($filepath);
                $img->removeAttribute('src');
                $img->setAttribute('src', $new_src);
            } // <!--endif
        } // <!-

        $content = $dom->saveHTML();

        $slug = $request->get('slug');
        $category_id = $request->get('category');
        $meta_description = $request->get('meta_description');
        $meta_keys = $request->get('meta_keys');
        $featured_img = $request->featured_img;

        $fi_file_name;
        $fi_src;

        if(!empty($featured_img)){
            $ext = $featured_img->getClientOriginalExtension();
            //$featured_img = base64_decode($featured_img);
            $newFeaturedImg = time().uniqid().'.'.$ext;
            $path = public_path() . "/assets/images/medias/" . $newFeaturedImg;

            $fi_file_name = $newFeaturedImg;

            $image = Image::make($featured_img)
                  ->save($path);  

            $fi_src = url('/') . "/assets/images/medias/" . $newFeaturedImg;
        }

        $uniqid = uniqid();

        $media = new Media(array(
            'file_name' => $fi_file_name,
            'src' => $fi_src,
            'file_type' => 0,
            'uniqid' => $uniqid
        ));
        $media->save();

        $get_media_id = Media::where('uniqid', $uniqid)->firstOrFail();
        $featured_img_id = $get_media_id->id;


        $post = new Post(array(
            'title' => $title,
            'content' => $content,
            'slug' => $slug,
            'status' => 1,
            'user_id' => Auth::user()->id,
            'author' => ucwords(Auth::user()->first_name)." ".ucwords(Auth::user()->last_name),
            'meta_description' => $meta_description,
            'meta_keys' => $meta_keys,
            'date_published' => date('Y-m-d H:i:s'),
            'featured_img' => $featured_img_id,
            'category_id' => $category_id,

        ));
        $post->save();
        return redirect('/admin/blogs')->with('status', $title.' post has been successfully published.');
    }

    public function edit_post($id) {
        $categories = Category::pluck('name', 'id');
        $categories[0] = "Others";
        $post = Post::whereId($id)->firstOrFail();
        $media = Media::whereId($post->featured_img)->firstOrFail();
        return view('admin.edit_blog', compact('post', 'media', 'categories'));
    }

    public function update_post($id, EditBlogFormRequest $request) {
        $post = Post::whereId($id)->firstOrFail();
        $media = Media::whereId($post->featured_img)->firstOrFail();

        $post->title = $request->get('title');
        $post->meta_description = $request->get('meta_description');
        $post->meta_keys = $request->get('meta_keys');
        $post->category_id = $request->get('category');

        if ($request->get('slug') != $post->slug) {
            $post_count = Post::where('slug', $request->get('slug'))->count();
            if ($post_count == 0) {
                $post->slug = $request->get('slug');
            }
            else {
                return redirect('/admin/blogs')->with('error', 'The slug has already been taken.');
            }
        }

        $content = $request->get('content');//this is the one with the message

        $dom = new \DOMDocument();
        $dom->loadHtml($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);    
        $images = $dom->getElementsByTagName('img');
        // foreach <img> in the submited message
        foreach($images as $img){
            $src = $img->getAttribute('src');
            
            // if the img source is 'data-url'
            if(preg_match('/data:image/', $src)){                
                // get the mimetype
                preg_match('/data:image\/(?<mime>.*?)\;/', $src, $groups);
                $mimetype = $groups['mime'];                
                // Generating a random filename
                $filename = uniqid();
                $filepath = "/assets/images/summernoteimages/$filename.$mimetype";
                //$filepath = "/summernoteimages/$filename.$mimetype";    
                // @see http://image.intervention.io/api/
                $image = Image::make($src)
                  // resize if required
                  /* ->resize(300, 200) */
                  ->encode($mimetype, 100)  // encode file to the specified mimetype
                  ->save(public_path($filepath));                
                $new_src = asset($filepath);
                $img->removeAttribute('src');
                $img->setAttribute('src', $new_src);
            } // <!--endif
        } // <!-

        $content = $dom->saveHTML();
        $post->content = $content;

        $featured_img = $request->featured_img;

        if(!empty($featured_img)){
            $ext = $featured_img->getClientOriginalExtension();
            //$featured_img = base64_decode($featured_img);
            $newFeaturedImg = time().uniqid().'.'.$ext;
            $path = public_path() . "/assets/images/medias/" . $newFeaturedImg;

            $fi_file_name = $newFeaturedImg;

            $image = Image::make($featured_img)
                  ->save($path);  

            $fi_src = url('/') . "/assets/images/medias/" . $newFeaturedImg;
            $media->src = $fi_src;
            $media->file_name = $fi_file_name;
        }

        $media->save();
        $post->save();


        return redirect('/admin/blogs')->with('status', $request->get('title').' post has been successfully updated.');
    }


    public function delete_post($id) {
        $post = Post::whereId($id)->firstOrFail();
        $title = $post->title;
        $post->delete();
        return redirect('/admin/blogs')->with('status', $title.' post has been successfully deleted.');
    }
}
