<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\Contact;

use App\Models\Property;
use App\Models\Message;
use App\Models\Gallery;
use App\Models\Comment;
use App\Models\Rating;
use App\Models\Mylike;
use App\Models\Post;
use App\Models\User;
use App\Models\Service;
use App\Models\Objective;
use App\Models\Team;

use App\Models\News;
use App\Models\Category;
use App\Models\Article;
use App\Models\Storie;
use App\Models\ArticlesDetial;
use App\Models\Aboutu;
use App\Models\Opportunity;
use App\Models\Course;
use App\Models\Library;
use App\Models\Video;
use App\Models\Myevent;
use App\Models\Program;

use App\Events\MediaViewer;
use Carbon\Carbon;
use Auth;
use DB;

class PagesController extends Controller
{
    public function properties()
    {
        $cities     = Property::select('city','city_slug')->distinct('city_slug')->get();
        $properties = Property::latest()->with('rating')->withCount('comments')->paginate(12);

        return view('pages.properties.property', compact('properties','cities'));
    }

    public function propertieshow($slug)
    {
        $property = Property::with('features','gallery','user','comments')
                            ->withCount('comments')
                            ->where('slug', $slug)
                            ->first();

        $rating = Rating::where('property_id',$property->id)->where('type','property')->avg('rating');                   

        $relatedproperty = Property::latest()
                    ->where('purpose', $property->purpose)
                    ->where('type', $property->type)
                    ->where('bedroom','<=', $property->bedroom)
                    ->where('bathroom','<=', $property->bathroom)
                    ->where('price','<=',$property->price)
                    ->where('id', '!=' , $property->id)
                    ->take(5)->get();

        // $relatedproperty = Property::latest()
        //             // ->where('purpose', $property->purpose)
        //             ->where('price','<=',$property->price)
        //             ->where('id', '!=' , $property->id)
        //             ->take(5)->get();


        $videoembed = $this->convertYoutube($property->video, '100%', 315);

        $cities = Property::select('city','city_slug')->distinct('city_slug')->get();

        return view('pages.properties.single', compact('property','rating','relatedproperty','videoembed','cities'));
    }
    // public function properties()
    // {
    //     $cities     = Property::select('city','city_slug')->distinct('city_slug')->get();
    //     $properties = Property::latest()->with('rating')->withCount('comments')->paginate(12);

    //     return view('pages.properties.property', compact('properties','cities'));
    // }

    // public function propertieshow($slug)
    // {
    //     $property = Property::with('features','gallery','user','comments')
    //                         ->withCount('comments')
    //                         ->where('slug', $slug)
    //                         ->first();

    //     $rating = Rating::where('property_id',$property->id)->where('type','property')->avg('rating');                   

    //     $relatedproperty = Property::latest()
    //                 ->where('purpose', $property->purpose)
    //                 ->where('type', $property->type)
    //                 ->where('bedroom','<=', $property->bedroom)
    //                 ->where('bathroom','<=', $property->bathroom)
    //                 ->where('price','<=',$property->price)
    //                 ->where('id', '!=' , $property->id)
    //                 ->take(5)->get();

    //     // $relatedproperty = Property::latest()
    //     //             // ->where('purpose', $property->purpose)
    //     //             ->where('price','<=',$property->price)
    //     //             ->where('id', '!=' , $property->id)
    //     //             ->take(5)->get();


    //     $videoembed = $this->convertYoutube($property->video, '100%', 315);

    //     $cities = Property::select('city','city_slug')->distinct('city_slug')->get();

    //     return view('pages.properties.single', compact('property','rating','relatedproperty','videoembed','cities'));
    // }

    public function news()
    {
        $data['categories'] = Category::get();
        $data['news']  = News::with('category')->with('rating')->withCount('comments')->where('select',1)->latest()->take(50)->get();
        // $news = News::latest()->with('rating')->withCount('comments')->paginate(12);

        return view('pages.media.news.news', $data);
    }

    public function newsshow($slug)
    {
        $news = News::with('category')
                            ->where('slug', $slug)
                            ->first();

        $rating = Rating::where('property_id',$news->id)->where('type','news')->avg('rating');   
        
        $likes = Mylike::where('likeable_id',$news->id)->where('likeable_type','App\Models\News')->sum('likes');    
        
        $relatednews = News::latest()
                    ->where('type', $news->type)
                    ->where('id', '!=' , $news->id)
                    ->take(5)->get();

       

        $videoembed = $this->convertYoutube($news->url_link, '100%', 315);

          // Share button 1
        $shareButtons1 = \Share::page(
            'https://www.yscyemen.org/en/news/'
        )
        ->facebook()
        ->twitter()
        ->linkedin()
        ->telegram()
        ->whatsapp()        
        ->reddit();

        return view('pages.media.news.single', compact('news','videoembed','rating','relatednews','likes')) 
            ->with('shareButtons1',$shareButtons1 );
    }

    public function articles()
    {
        $categories     = Category::get();
        $articles = Article::latest()->with('rating')->withCount('comments')->paginate(12);

        return view('pages.media.articles.articles', compact('articles','categories'));
    }

    public function articlesshow($slug)
    {
        $articles = Article::with('category')
                            ->where('slug', $slug)
                            ->first();

        $ArticlesDetials = ArticlesDetial::where('article_id', $articles->id)->get();

        $rating = Rating::where('property_id',$articles->id)->where('type','articles')->avg('rating');                   
        
        $relatedarticles = Article::latest()
                    ->where('type', $articles->type)
                    ->where('id', '!=' , $articles->id)
                    ->take(5)->get();

       

        $videoembed = $this->convertYoutube($articles->url_link, '100%', 315);

        // $cities = Property::select('city','city_slug')->distinct('city_slug')->get();

        return view('pages.media.articles.single', compact('articles','videoembed','rating','relatedarticles','ArticlesDetials'));
    }

     // articles Category
     public function articlesCategory($catslug)
     {
 
         $data['categories'] = Category::latest()->take(10)->get();
         $data['articles']  = Article::with('category')
                                 ->where('type', $catslug)
                                 ->where('select',1)->latest()->take(50)->get();
         // $news = News::latest()->with('rating')->withCount('comments')->paginate(12);
 
         return view('pages.media.articles.articles', $data);
 
       
     }


    public function stories()
    {
        $categories     = Category::get();
        $Stories = Storie::latest()->paginate(12);

        return view('pages.media.stories.stories', compact('Stories','categories'));
    }

    public function storiesshow($slug)
    {
        $stories = Storie::with('category')
                            ->where('slug', $slug)
                            ->first();   

        $videoembed = $this->convertYoutube($stories->url_link, '100%', 315);

        // $cities = Property::select('city','city_slug')->distinct('city_slug')->get();

        return view('pages.media.stories.single', compact('stories','videoembed'));
    }

         // Stories Category
         public function storiesCategory($catslug)
         {
     
             $data['categories'] = Category::latest()->take(10)->get();
             $data['Stories']  = Storie::with('category')
                                     ->where('type', $catslug)
                                     ->where('select',1)->latest()->take(50)->get();
             // $news = News::latest()->with('rating')->withCount('comments')->paginate(12);
     
             return view('pages.media.stories.stories', $data);
     
           
         }


    // AGENT PAGE
    public function myservices()
    {
        $myservices = Service::latest()->paginate(12);

        return view('pages.services.index', compact('myservices'));
    }

    public function myservicesshow($id)
    {
        $myservice = Service::findOrFail($id);
        return view('pages.services.single', compact('myservice'));
    }

    public function myprograms()
    {
        $myprograms = Program::latest()->paginate(12);

        return view('pages.programs.index', compact('myprograms'));
    }

    public function myprogramsshow($id)
    {
        $myprogram = Program::findOrFail($id);
        return view('pages.programs.single', compact('myprogram'));
    }

    public function myversions()
    {
        $data['courses'] = Course::latest()->paginate(2);
        $data['videos'] = Video::latest()->paginate(2);
        $data['centerLibrary'] = Library::where('type', 1)->latest()->paginate(2);
        $data['myversions'] = Library::where('type', 2)->latest()->paginate(2);
        return view('pages.versions.index', $data);
    }

    public function myversionsshow($id,$type)
    {
        if($type == 'course')
        {
            $data['mbtype'] = 'course';
            $data['courses'] = Course::findOrFail($id);
            $courses = Course::findOrFail($id);
            $data['videoembed'] = $this->convertYoutube($courses->url_link, '100%', 315);
            return view('pages.versions.singlecourses', $data);
        }

        elseif($type == 'video')
        {
            $data['mbtype'] = 'video';
            $data['videos'] = Video::findOrFail($id);
            $videos = Video::findOrFail($id);
            $data['videoembed'] = $this->convertYoutube($videos->url_link, '100%', 315);
            return view('pages.versions.singlevideos', $data);
        }

        elseif($type == 'clibrary')
        {
            $data['mbtype'] = 'clibrary';
            $data['centerLibrary'] = Library::findOrFail($id);
            $centerLibrary = Library::findOrFail($id);
            $data['videoembed'] = $this->convertYoutube($centerLibrary->url_link, '100%', 315);
            return view('pages.versions.singleclibrary', $data);
        }

        else
        {
            $data['mbtype'] = 'myversion';
            $data['myversions'] = Library::findOrFail($id);
            $myversions = Library::findOrFail($id);
            $data['videoembed'] = $this->convertYoutube($myversions->url_link, '100%', 315);
            return view('pages.versions.singlemyversion', $data);
        }
        
        
        return view('pages.versions.single', $data);
    }

    public function myevents()
    {
        // $myevents = Service::latest()->paginate(12);

        // $myevent = Myevent::where('id',1)->first();
        // event(new MediaViewer($myevent));
        return view('pages.events.index');
    }

    public function appdownload($id)
    {
        // $myevents = Service::latest()->paginate(12);

        $myevent = Myevent::where('id',$id)->first();
        event(new MediaViewer($myevent));
        return $myevent;
    }

    public function courses()
    {
        $courses = Course::latest()->paginate(12);

        return view('pages.courses.index', compact('courses'));
    }


    public function coursesshow($id)
    {
        $courses = Course::latest()->where('select', 1)->get();

        return view('pages.courses.single', compact('courses'));
    }



    public function aboutus()
    {
      
        $data['aboutus'] = Aboutu::latest()->take(1)->get();
        $data['Objectives'] = Objective::where('select',1)->get();
        $data['counts'] = Objective::count();
        $data['Teams'] = Team::where('select',1)->get();
        return view('pages.aboutus.index', $data);
        
    }

    // AGENT PAGE
    public function agents()
    {
        $agents = User::latest()->where('role_id', 2)->paginate(12);

        return view('pages.agents.index', compact('agents'));
    }



    public function agentshow($id)
    {
        $agent      = User::findOrFail($id);
        $properties = Property::latest()->where('agent_id', $id)->paginate(10);

        return view('pages.agents.single', compact('agent','properties'));
    }

    public function opportunityshow($id)
    {
        // $agent      = User::findOrFail($id);
        $opportunities = Opportunity::where('id',$id)->first();

        return view('pages.opportunities.single', compact('opportunities'));
    }

    // BLOG PAGE
    public function blog()
    {
        $month = request('month');
        $year  = request('year');

        $posts = Post::latest()->withCount('comments')
                                ->when($month, function ($query, $month) {
                                    return $query->whereMonth('created_at', Carbon::parse($month)->month);
                                })
                                ->when($year, function ($query, $year) {
                                    return $query->whereYear('created_at', $year);
                                })
                                ->where('status',1)
                                ->paginate(10);

        return view('pages.blog.index', compact('posts'));
    }

    public function blogshow($slug)
    {
        $post = Post::with('comments')->withCount('comments')->where('slug', $slug)->first(); 

        $blogkey = 'blog-' . $post->id;
        if(!Session::has($blogkey)){
            $post->increment('view_count');
            Session::put($blogkey,1);
        }

        return view('pages.blog.single', compact('post'));
    }


    // BLOG COMMENT
    public function blogComments(Request $request, $id)
    {
        $request->validate([
            'body'  => 'required'
        ]);

        $post = Post::find($id);

        $post->comments()->create(
            [
                'user_id'   => Auth::id(),
                'body'      => $request->body,
                'parent'    => $request->parent,
                'parent_id' => $request->parent_id
            ]
        );

        return back();
    }


    // BLOG CATEGORIES
    public function blogCategories()
    {
        $posts = Post::latest()->withCount(['comments','categories'])
                                ->whereHas('categories', function($query){
                                    $query->where('categories.slug', '=', request('slug'));
                                })
                                ->where('status',1)
                                ->paginate(10);

        return view('pages.blog.index', compact('posts'));
    }

    // BLOG TAGS
    public function blogTags()
    {
        $posts = Post::latest()->withCount('comments')
                                ->whereHas('tags', function($query){
                                    $query->where('tags.slug', '=', request('slug'));
                                })
                                ->where('status',1)
                                ->paginate(10);

        return view('pages.blog.index', compact('posts'));
    }

    // BLOG AUTHOR
    public function blogAuthor()
    {
        $posts = Post::latest()->withCount('comments')
                                ->whereHas('user', function($query){
                                    $query->where('username', '=', request('username'));
                                })
                                ->where('status',1)
                                ->paginate(10);

        return view('pages.blog.index', compact('posts'));
    }



    // MESSAGE TO AGENT (SINGLE AGENT PAGE)
    public function messageAgent(Request $request)
    {
        $request->validate([
            'agent_id'  => 'required',
            'name'      => 'required',
            'email'     => 'required',
            'phone'     => 'required',
            'message'   => 'required'
        ]);

        Message::create($request->all());

        if($request->ajax()){
            return response()->json(['message' => 'Message send successfully.']);
        }

    }

    
    // CONATCT PAGE
    public function contact()
    {
        $data['contacts'] = \App\Models\Contact::latest()->first();
        return view('pages.contact',$data);
    }

    public function messageContact(Request $request)
    {
        $request->validate([
            'name'      => 'required',
            'email'     => 'required',
            'phone'     => 'required',
            'message'   => 'required'
        ]);

        $message  = $request->message;
        $mailfrom = $request->email;
        
        Message::create([
            'agent_id'  => 1,
            'name'      => $request->name,
            'email'     => $mailfrom,
            'phone'     => $request->phone,
            'message'   => $message
        ]);
            
        $adminname  = User::find(1)->name;
        $mailto     = $request->mailto;

        Mail::to($mailto)->send(new Contact($message,$adminname,$mailfrom));

        if($request->ajax()){
            return response()->json(['message' => 'Message send successfully.']);
        }

    }

    public function contactMail(Request $request)
    {
        return $request->all();
    }


    // GALLERY PAGE
    public function gallery()
    {
        $galleries = Gallery::latest()->paginate(12);

        return view('pages.gallery',compact('galleries'));
    }


    // PROPERTY COMMENT
    public function propertyComments(Request $request, $id)
    {
        $request->validate([
            'body'  => 'required'
        ]);

        $property = Property::find($id);

        $property->comments()->create(
            [
                'user_id'   => Auth::id(),
                'body'      => $request->body,
                'parent'    => $request->parent,
                'parent_id' => $request->parent_id
            ]
        );

        return back();
    }


    // PROPERTY RATING
    public function propertyRating(Request $request)
    {
        $rating      = $request->input('rating');
        $property_id = $request->input('property_id');
        $user_id     = $request->input('user_id');
        $type        = 'property';

        $rating = Rating::updateOrCreate(
            ['user_id' => $user_id, 'property_id' => $property_id, 'type' => $type],
            ['rating' => $rating]
        );

        if($request->ajax()){
            return response()->json(['rating' => $rating]);
        }
    }

    // news RATING
    public function newsRating(Request $request)
    {
        $rating      = $request->input('rating');
        $news_id = $request->input('news_id');
        $user_id     = $request->input('user_id');
        $type        = 'news';

        $rating = Rating::updateOrCreate(
            ['user_id' => $user_id, 'property_id' => $news_id, 'type' => $type],
            ['rating' => $rating]
        );

        if($request->ajax()){
            return response()->json(['rating' => $rating]);
        }
    }

       // news likes
       public function newsLikes(Request $request)
       {
      
      
           $mylikes      = $request->like_type;
           $news_id = $request->mypost_id;
           $user_id     = $request->user_id;
           $type        = 'App\Models\News';

            Mylike::updateOrCreate(
               [
                'user_id' => $user_id,
                'likeable_id' => $news_id, 
                'likeable_type' => $type,
                'likes' => $mylikes
                ]
           );

           $likes = Mylike::where('likeable_id',$news_id)->where('likeable_type','App\Models\News')->sum('likes');  

           return response()->json(
            [
                'status' => true,
                'username' => 'modhi',
                'likes' => $likes,
               
            ]
        );
   
          
       }

     // news COMMENT
     public function newsComments(Request $request, $id)
     {
         $request->validate([
             'body'  => 'required'
         ]);
 
         $news = news::find($id);
 
         $news->comments()->create(
             [
                 'user_id'   => Auth::id(),
                 'body'      => $request->body,
                 'parent'    => $request->parent,
                 'parent_id' => $request->parent_id
             ]
         );
 
         return back();
     }

        // News Category
    public function newsCategory($catslug)
    {

        $data['categories'] = Category::latest()->take(10)->get();
        $data['news']  = News::with('category')->with('rating')->withCount('comments')
                                ->where('type', $catslug)
                                ->where('select',1)->latest()->take(50)->get();
        // $news = News::latest()->with('rating')->withCount('comments')->paginate(12);

        return view('pages.media.news.news', $data);

      
    }
 


    // PROPERTY CITIES
    public function propertyCities()
    {
        $cities     = Property::select('city','city_slug')->distinct('city_slug')->get();
        $properties = Property::latest()->with('rating')->withCount('comments')
                        ->where('city_slug', request('cityslug'))
                        ->paginate(12);

        return view('pages.properties.property', compact('properties','cities'));
    }


    // YOUTUBE LINK TO EMBED CODE
    private function convertYoutube($youtubelink, $w = 250, $h = 140) {
        return preg_replace(
            "/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
            "<iframe width=\"$w\" height=\"$h\" src=\"//www.youtube.com/embed/$2\" frameborder=\"0\" allowfullscreen></iframe>",
            $youtubelink
        );
    }
    
}
