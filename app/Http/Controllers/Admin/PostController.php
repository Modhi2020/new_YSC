<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Comment;
use App\Models\PostApproved;
use App\Models\PostStatu;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use Toastr;
use Auth;
use App\Traits\AttachFilesTrait;

class PostController extends Controller
{

    use AttachFilesTrait;
    
    public function index()
    {
        $data['posts'] = Post::latest()->withCount('comments')->get();
        $data['PostApproveds'] = PostApproved::get();
        $data['PostStatus'] = PostStatu::get();

        return view('admin.posts.index',$data);
    }


    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.create',compact('categories','tags'));
    }


    public function store(Request $request)
    {
      
        $request->validate([
            // 'title'     => 'required|unique:posts|max:255',
            // 'title_ar'     => 'required|max:255|unique:posts|,title',
            // 'title_en'     => 'required|max:255|unique:posts|,title',
          //  'image'     => 'required|mimes:jpeg,jpg,png',
            'categories'=> 'required',
            'tags'      => 'required',
            // 'body'      => 'required'
            'body_ar'      => 'required',
            'body_en'      => 'required'
        ]);

      
        $image = $request->file('image');
        $slug  = str_slug($request->title_en);

        // $postimage = Image::make($image)->resize(1600, 980, function ($constraint) {$constraint->aspectRatio();$constraint->upsize();})->save($pathe.$imagename);

        if ($request->hasFile('image')) 
        {
            $file = $request->file('image');
            $folder = $request->folder;
            $date = date('Y-m-d');
            $name = $date . rand() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('attachments/'.$folder.'/'.$slug.'/images', $name,'upload_attachments');
            $imagename = $name;
            $path = 'attachments/'.$folder.'/'.$slug.'/images';

        }
        else
        {
            $imagename = 'default.png';
            $path = 'attachments/posts';
        }


        $post = new Post();
        $post->user_id = Auth::id();
        $post->title = ['en' => $request->title_en, 'ar' => $request->title_ar];
        $post->slug = $slug;
        $post->image = $imagename;
        $post->path = $path;
        $post->body = ['en' => $request->body_en, 'ar' => $request->body_ar];
        if(isset($request->status)){
            $post->status = true;
        }
        $post->is_approved = true;
        $post->save();

        $post->categories()->attach($request->categories);
        $post->tags()->attach($request->tags);

        Toastr::success('message', 'Post created successfully.');
        return redirect()->route('admin.posts.index');

    }


    public function show(Post $post)
    {
        $post = Post::withCount('comments')->find($post->id);

        return view('admin.posts.show',compact('post'));
    }


    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();
        $post = Post::find($post->id);

        $selectedtag = $post->tags->pluck('id');

        return view('admin.posts.edit',compact('categories','tags','post','selectedtag'));
    }


    public function update(Request $request, $post)
    {
        $request->validate([
            // 'title'     => 'required|max:255',
         //   'image'     => 'mimes:jpeg,jpg,png',
            'categories'=> 'required',
            'tags'      => 'required',
            // 'body'      => 'required'
        ]);

        $image = $request->file('image');
        // $slug  = str_slug($request->title_en);
        
       
        $post = Post::find($request->id);

        // if($request->hasFile('image')) 
        // {
            
        //     if(!Storage::disk('upload_attachments')->exists('posts'))
        //     {
        //         Storage::disk('upload_attachments')->makeDirectory('posts');
        //     }
            // if(Storage::disk('upload_attachments')->exists('posts/'.$post->getTranslation('title', 'en').'/'.$post->image))
            // {
            //     Storage::disk('upload_attachments')->delete('posts/'.$post->getTranslation('title', 'en').'/'.$post->image);
            // }
            
            // $pathed='/attachments/posts/'.$post->title.'/';         
            // $sliderimg = Image::make($image)->resize(1800, 480, function ($constraint) {$constraint->aspectRatio();$constraint->upsize();})->save($pathed.$image);

            // $logo_name = $request->file('image')->getClientOriginalName();
            // $imagename = $logo_name;
            // $path_pub=public_path();
            // $patt='\attachments\posts';
            // $pathe=$path_pub.$patt.$post->slug;
            
            // $postimage = Image::make($image)->resize(1600, 980, function ($constraint) {$constraint->aspectRatio();$constraint->upsize();})->save($pathe.$imagename);
            // Storage::disk('upload_attachments')->put('property/'.$imagefloorplan, $propertyfloorplan);
            // Slider::where('id', $request->id)->update(['image' => $logo_name]);
           
           
            // $this->uploadFile($request,'image','posts'.'/'.$request->title_en);

          //  $postimage = Image::make($image)->resize(1600, 980)->save();
            // Storage::disk('upload_attachments')->put('posts/'.$post->slug.'/'.$imagename, $postimage);
            
        // }


        if ($request->hasFile('image')) 
        {
            $file = $request->file('image');
            $folder = $request->folder;
            $date = date('Y-m-d');
            $name = $date . rand() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('attachments/'.$folder.'/'.$slug.'/images', $name,'upload_attachments');
            $imagename = $name;
            $path = 'attachments/'.$folder.'/'.$slug.'/images';

        }
        else
        {
            $imagename = $post->image;
            $path = 'attachments/posts';
        }

        $post->user_id = Auth::id();
        $post->title =['en' => $request->title_en, 'ar' => $request->title_ar];
        // $post->slug = $slug;
        $post->image = $imagename;
        $post->body = ['en' => $request->body_en, 'ar' => $request->body_ar];
        if(isset($request->status)){
            $post->status = true;
        }else{
            $post->status = false;
        }
        $post->is_approved = true;
        $post->save();

        $post->categories()->sync($request->categories);
        $post->tags()->sync($request->tags);

        Toastr::success('message', 'Post updated successfully.');
        return redirect()->route('admin.posts.index');
    }


    public function destroy(Post $post)
    {
        $post = Post::find($post->id);

        if(Storage::disk('upload_attachments')->exists('posts/'.$post->title.'/'.$post->image))
        {
            Storage::disk('upload_attachments')->delete('posts/'.$post->title.'/'.$post->image);
        }

        $post->delete();
        $post->categories()->detach();
        $post->tags()->detach();
        $post->comments()->delete();

        Toastr::success('message', 'Post deleted successfully.');
        return back();
    }
}
