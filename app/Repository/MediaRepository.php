<?php

namespace App\Repository;

use App\Models\Agree;
use App\Models\TasksType;
use App\Models\TaskState;
use App\Models\TasksMaster;
use App\Models\TasksDetail;
use App\Models\TaskDegree;
use App\Models\TaskFile;
use App\Models\Category;
use App\Models\MediaFile;
use App\Models\ArticlesImage;

use App\Models\News;
use App\Models\Article;
use App\Models\ArticlesDetial;
use App\Models\Storie;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Validator;
use File;
use App\Traits\AttachFilesTrait;
use App\Traits\UploadMultiImagesTrait;

class MediaRepository implements MediaRepositoryInterface
{

    use UploadMultiImagesTrait;

    public function index()
    {
        $data['Agrees'] = Agree::all();
        $data['TasksTypes'] = TasksType::all();
        $data['TaskStates'] = TaskState::all();
        $data['TaskDegrees'] = TaskDegree::all();
        $data['Responsibles'] = User::all();
        $data['Supervisors'] = User::all();
        $data['Commissioners'] = User::all();
        $data['TasksMasters'] = TasksMaster::all();
        $data['TasksDetails'] = TasksDetail::all();
        $data['Categories'] = Category::all();
        return view('admin.medias.index', $data);
    }

    public function create()
    {
      
    }

    public function store($request)
    {  
        
        try {     
           
                if ($request->request_type == 1) 
                {

                  

                    if(isset($request->ready))
                    {
                        $ready = 1;
                    }
                    else{
                        $ready = 2;
                    }

                    $slug  = str_slug($request->title_ar);
                    $news = new News();
                    $news->title = ['en' => $request->title_en, 'ar' => $request->title_ar];
                    $news->details = ['en' => $request->details_en, 'ar' => $request->details_ar];
                    $news->slug = $slug;
                    $news->ready = $ready;
                    $news->date = date('Y-m-d');
                    // $news->type = $request->type;
                    $news->url_link = $request->video;
                    $news->save();
                  
                    return response()->json(
                        [
                            'status' => true,
                            'username' => 'modhi',
                            'slug' => $slug,
                            'id' => $news->id,
                            // 'file' =>   urldecode($request->photos) ,
                        ]
                    );
                           
                }
                else 
                {
                   
                }

                
                    
           
        }
        catch (\Exception $e) {
            // DB::rollback();
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    function upload_image($request)
    {
     $validation = Validator::make($request->all(), [
      'select_file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
     ]);
     if($validation->passes())
     {
         $dsa = $request->notesfsd . 'gj';
      $image = $request->file('select_file');
      $new_name = rand() . '.' . $image->getClientOriginalExtension();
      $image->move(public_path('images'), $new_name);
      return response()->json([
       'message'   => 'Image Upload Successfully',
       'modhi'   => $dsa,
       'uploaded_image' => '<img src="/images/'.$new_name.'" class="img-thumbnail" width="300" />',
       'class_name'  => 'alert-success'
      ]);
     }
     else
     {
      return response()->json([
       'message'   => $validation->errors()->all(),
       'uploaded_image' => '',
       'class_name'  => 'alert-danger'
      ]);
     }
    }

    public function upload_files($request)
    {
        // return response()->json(['success'=>'Ajax Multiple fIle has been uploaded']);
       $validatedData = $request->validate([
        // 'files' => 'required',
        'files.*' => 'mimes:csv,txt,xlx,xls,pdf,jpeg,png,jpg,gif'
        ]);
 
        if($request->TotalFiles > 0)
        {
                
           for ($x = 0; $x < $request->TotalFiles; $x++) 
           {
 
               if ($request->hasFile('files'.$x)) 
                {
                   
 
                    $slug = $request->slug;
                    $id = $request->id;

                    $file  = $request->file('files'.$x);
                    // $path = $file->store('public/files');
                    $name = rand() . '.' . $file->getClientOriginalExtension();
                    // $name = $file->getClientOriginalName();
                    $file->storeAs('attachments/tasks/'.$request->slug.'/files', $file->getClientOriginalName(),'upload_attachments');
                   
                    $insert[$x]['filename'] = $name;
                    $insert[$x]['imageable_id'] = $id;
                    $insert[$x]['type'] = 2;

                   
                }
           }
 
           TaskFile::insert($insert);
 
            return response()->json(['success'=>'Ajax Multiple fIle has been uploaded']);
 
        }
        else
        {
           return response()->json(["message" => "Please try again."]);
        }
 
    }

    public function upload_images($request)
    {
       
        $this->UploadMultiImagesTrait($request);
        return response()->json(
            [
                'status' => true,
                'username' => 'modhi',
                // 'file' =>   urldecode($request->photos) ,
            ]
        );
    }

    public function show($id)
    {
        $data['Exchanges'] = Exchange::findorFail($id);
        // $data['Currency'] = Currency::all();
        $data['Currency'] = Currency::where('id','<>',1)->get();
        $data['Schools'] = School::all();
        return view('pages.Exchanges.edit', $data);
    }

    public function edit($id)
    {

        $TasksMasters =  News::where('id',$id)->get();
       

        $data['News'] = News::with('category')->where('id',$id)->get();
        $data['Newsimage'] = MediaFile::where('imageable_id',$id)->get();
        return  $data ;
    }

    public function update($request)
    {        
        
        try {       
                if ($request->request_type == 1) 
                {

                    if(isset($request->ready))
                    {
                        $ready = 1;
                    }
                    else{
                        $ready = 2;
                    }

                    $news = News::findorFail($request->news_id);
                    $news->title = ['en' => $request->title_ens, 'ar' => $request->title_ars];
                    $news->details = ['en' => $request->details_ens, 'ar' => $request->details_ars];
                    $news->ready = $ready;
                    // $news->date = date('Y-m-d');
                    $news->type = $request->newtypes;
                    $news->url_link = $request->newvideos;
                    $news->save();
                    $slug = $news->slug;

                    return response()->json(
                        [
                            'status' => true,
                            'username' => 'modhi',
                            'slug' => $slug,
                            'id' => $news->id,
                        ]
                    );
                           
                }
                else 
                {
                   
                }

                
                    
           
        }
        catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $News = News::findOrFail($id);
            $News->select = 0;
            $News->save();

            return response()->json(
                [
                    'status' => true,
                    'username' => 'modhi',
                ]
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => false,
                    'username' => 'modhi',
                    'error' => $e->getMessage(),
                ]
            );
        }
    }

    public function NewsShow()
    {
        $News = News::with('category')->where('select',1)->latest()->take(6)->get();


        return $News;

    }

    public function getArticalById($id)
    {

        $TasksMasters =  Article::where('id',$id)->get();
       

        $data['News'] = Article::where('id',$id)->get();
        $data['Newsimage'] = MediaFile::where('imageable_id',$id)->get();
        return  $data ;
    }

    public function articalsStore($request)
    {   
        
        try {       
                if ($request->sub_article == 2) 
                {   

                    if(isset($request->ready))
                    {
                        $ready = 1;
                    }
                    else{
                        $ready = 2;
                    }
                   
                    $slug  = str_slug($request->title_ar);
                    $Articles = new Article();
                    $Articles->title = ['en' => $request->title_en, 'ar' => $request->title_ar];
                    $Articles->details = ['en' => $request->details_en, 'ar' => $request->details_ar];
                    $Articles->slug = $slug;
                    $Articles->ready = $ready;
                    $Articles->date = date('Y-m-d');
                    $Articles->type = $request->type;
                    $Articles->url_link = $request->video;
                  
                    if ($request->hasFile('image')) 
                    {
                        $file = $request->file('image');
                        $folder = $request->folder;
                        $date = date('Y-m-d');
                        $name = $date . rand() . '.' . $file->getClientOriginalExtension();
                        $file->storeAs('attachments/'.$folder.'/'.$request->slug.'/images', $name,'upload_attachments');
                        $imagename = $name;
                        $path = 'attachments/'.$folder.'/'.$request->slug.'/images';

                    }

            
                    else
                    {
                        $imagename = 'default.png';
                        $path = 'attachments/media';
                    }

                    $Articles->image = $imagename;
                    $Articles->path = $path;
                    $Articles->save();
                  
                    return response()->json(
                        [
                            'status' => true,
                            'username' => 'modhi',
                            'slug' => $slug,
                            'id' => $Articles->id,
                            // 'file' =>   urldecode($request->photos) ,
                        ]
                    );
                           
                }
                else 
                {

                    if ($request->TotalFiles > 0)
                    {
                        
                        for ($x = 0; $x < $request->TotalFiles; $x++) 
                        {
                           
                
                            if (isset($request->TotalFiles)) 
                             {
                                 $title_ar = 'title_ar'.$x;
                                 $title_en = 'title_en'.$x;
                                 $details_ar = 'details_ar'.$x;
                                 $details_en = 'details_en'.$x;
                                 $video = 'video'.$x;
                                 $details_ar = 'details_ar'.$x;
                                //  $images = 'images'.$x;
                                 $title_ar  = $request->$title_ar;
                                 $title_en  = $request->$title_en;
                                 $details_ar  = $request->$details_ar;
                                 $details_en  = $request->$details_en;
                                //  $images  = $request->$images;
                                 $video  = $request->$video;
                                 $slug = $request->slug;
                                 $id = $request->id;
                            
                                //  $insert[$x]['title'] = ['en' => $title_en, 'ar' => $title_ar];
                                //  $insert[$x]['details'] = ['en' => $details_en, 'ar' => $details_ar];
                                //  $insert[$x]['article_id'] = $id;
                                //  $insert[$x]['video'] = $video;
    
                                // ArticlesDetial::insert($insert);
                                $ArticlesDetials = new ArticlesDetial();
                                $ArticlesDetials->title = ['en' => $title_en, 'ar' => $title_ar];
                                $ArticlesDetials->details = ['en' => $details_en, 'ar' => $details_ar];
                               
                                $ArticlesDetials->article_id = $id;
                                $ArticlesDetials->url_link = $video;
                           
                                $x++; 
                                $x++; 
                                if ($request->hasFile('images'.$x)) 
                                {
                                    $file = $request->file('images'.$x);
                                    $folder = $request->folder;
                                    $date = date('Y-m-d');
                                    $name = $date . rand() . '.' . $file->getClientOriginalExtension();
                                    $file->storeAs('attachments/'.$folder.'/'.$request->slug.'/images', $name,'upload_attachments');
                                    $imagename = $name;
                                    $path = 'attachments/'.$folder.'/'.$request->slug.'/images';
            
                                }
                        
                                else
                                {
                                    $imagename = 'default.png';
                                    $path = 'attachments/media';
                                }
                                $x--;
                                $x--;  
    
                                $ArticlesDetials->image = $imagename;
                                $ArticlesDetials->path = $path;
                                $ArticlesDetials->save();
    
                              
                                 
                                
                             }
                             
                        }
                        return response()->json(
                            [
                                'status' => true,
                                'username' => 'modhi',
                                'ArticlesDetial' => 'ArticlesDetial',
                                // 'file' =>   urldecode($request->photos) ,
                            ]
                        );
                    }
                   
                }
            
           
        }
        catch (\Exception $e) {
            // DB::rollback();
            return response()->json(
                [
                    'status' => false,
                    'username' => 'modhi',
                    'error' => $e->getMessage(),
                ]
            );
        }
    }

    public function upload_articals_images($request)
    {
        for ($x = 0; $x < $request->TotalFiles; $x++) 
        {

            if ($request->hasFile('images'.$x)) 
             {
                 $file      = $request->file('images'.$x);
                 $slug = $request->slug;
                 $id = $request->id;
                 $folder = $request->folder;
                 $page = $request->page;
                 // $path = $file->store('public/images');
                 $date = date('Y-m-d');
                 $name = $date . rand() . '.' . $file->getClientOriginalExtension();
                 // $name = $file->getClientOriginalName();
                 $file->storeAs('attachments/'.$folder.'/'.$request->slug.'/images', $name,'upload_attachments');

                 $insert[$x]['filename'] = $name;
                 $insert[$x]['imageable_id'] = $id;
                 $insert[$x]['subart_id'] = $id;
                 $insert[$x]['page'] = $page;
                 $insert[$x]['type'] = 1;
             }
             
        }
        $model = $request->model;
        $model::insert($insert);
    }
   
    public function ArticalsShow()
    {
        $Articles = Article::with('category')->where('select',1)->latest()->take(6)->get();
        return $Articles;

    }

    public function updateArtical($request)
    {        
        
        try {       
                if ($request->request_type == 1) 
                {
                    if(isset($request->ready))
                    {
                        $ready = 1;
                    }
                    else{
                        $ready = 2;
                    }

                    $Articles = Article::findorFail($request->artical_id);
                    $Articles->title = ['en' => $request->arttitle_ens, 'ar' => $request->arttitle_ars];
                    $Articles->details = ['en' => $request->artdetails_ens, 'ar' => $request->artdetails_ars];
                    $Articles->ready = $ready;
                    $Articles->date = date('Y-m-d');
                    $Articles->type = $request->arttypes;
                    $Articles->url_link = $request->artvideos;
                    $slug = $Articles->slug;
                              
                    if ($request->hasFile('image')) 
                    {
                        $file = $request->file('image');
                        $folder = $request->folder;
                        $date = date('Y-m-d');
                        $name = $date . rand() . '.' . $file->getClientOriginalExtension();
                        $file->storeAs('attachments/'.$folder.'/'.$request->slug.'/images', $name,'upload_attachments');
                        $imagename = $name;
                        $path = 'attachments/'.$folder.'/'.$request->slug.'/images';

                    }

            
                    else
                    {
                        $imagename = $Articles->image ;
                        $path = $Articles->path ;
                    }

                    $Articles->image = $imagename;
                    $Articles->path = $path;

                    $Articles->save();

                    return response()->json(
                        [
                            'status' => true,
                            'username' => 'modhi',
                            'slug' => $slug,
                            'id' => $Articles->id,
                        ]
                    );
                           
                }
                else 
                {
                 
                }

                
                    
           
        }
        catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function destroyArtical($id)
    {
        try {
            $Articles = Article::findOrFail($id);
            $Articles->select = 0;
            $Articles->save();

            return response()->json(
                [
                    'status' => true,
                    'username' => 'modhi',
                ]
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => false,
                    'username' => 'modhi',
                    'error' => $e->getMessage(),
                ]
            );
        }
    }


    public function getStoriesById($id)
    {

        $TasksMasters =  Storie::where('id',$id)->get();
       

        $data['Stories'] = Storie::with('category')->where('id',$id)->get();
        $data['Newsimage'] = MediaFile::where('imageable_id',$id)->get();
        return  $data ;
    }

    public function StoriesStore($request)
    {   
               
        try {       
                if ($request->request_type == 1) 
                {   

                    if(isset($request->ready))
                    {
                        $ready = 1;
                    }
                    else{
                        $ready = 2;
                    }
                   
                    $slug  = str_slug($request->title_ar);
                    $Stories = new Storie();
                    $Stories->title = ['en' => $request->title_en, 'ar' => $request->title_ar];
                    $Stories->details = ['en' => $request->details_en, 'ar' => $request->details_ar];
                    $Stories->slug = $slug;
                    $Stories->ready = $ready;
                    $Stories->date = date('Y-m-d');
                    $Stories->type = $request->type;
                    $Stories->url_link = $request->video;

                    if ($request->hasFile('images')) 
                    {
                        $file = $request->file('images');
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
                        $path = 'attachments/media';
                    }

                    $Stories->image = $imagename;
                    $Stories->path = $path;

                    $Stories->save();
                  
                    return response()->json(
                        [
                            'status' => true,
                            'username' => 'modhi',
                            'slug' => $slug,
                            'id' => $Stories->id,
                            // 'file' =>   urldecode($request->photos) ,
                        ]
                    );
                           
                }
                else 
                {
                   
                }
            
           
        }
        catch (\Exception $e) {
            // DB::rollback();
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

   
    public function StoriesShow()
    {
        $Stories = Storie::with('category')->where('select',1)->latest()->take(6)->get();
        return $Stories;

    }

    public function updateStories($request)
    {        
        
        try {       
        
                if ($request->request_type == 1) 
                {
                    if(isset($request->ready))
                    {
                        $ready = 1;
                    }
                    else{
                        $ready = 2;
                    }

                    $Stories = Storie::findorFail($request->story_id);
                    $Stories->title = ['en' => $request->stotitle_ens, 'ar' => $request->stotitle_ars];
                    $Stories->details = ['en' => $request->stodetails_ens, 'ar' => $request->stodetails_ars];
                    $Stories->ready = $ready;
                    $Stories->type = $request->stotypes;
                    $Stories->url_link = $request->stovideos;
                    $slug = $Stories->slug;

                    if ($request->hasFile('images')) 
                    {
                        $file = $request->file('images');
                        $folder = $request->folder;
                        $date = date('Y-m-d');
                        $name = $date . rand() . '.' . $file->getClientOriginalExtension();
                        $file->storeAs('attachments/'.$folder.'/'.$slug.'/images', $name,'upload_attachments');
                        $imagename = $name;
                        $path = 'attachments/'.$folder.'/'.$slug.'/images';

                    }

            
                    else
                    {
                        $imagename =  $Stories->image;
                        $path =  $Stories->path;
                    }

                    $Stories->image = $imagename;
                    $Stories->path = $path;

                    $Stories->save();
                

                    return response()->json(
                        [
                            'status' => true,
                            'username' => 'modhi',
                            'slug' => $slug,
                            'id' => $Stories->id,
                        ]
                    );
                           
                }
                else 
                {
                 
                }

                
                    
           
        }
        catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function destroyStories($id)
    {
        try {
            $Stories = Storie::findOrFail($id);
            $Stories->select = 0;
            $Stories->save();

            return response()->json(
                [
                    'status' => true,
                    'username' => 'modhi',
                ]
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => false,
                    'username' => 'modhi',
                    'error' => $e->getMessage(),
                ]
            );
        }
    }
}
