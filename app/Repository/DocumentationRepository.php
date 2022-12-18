<?php

namespace App\Repository;

use App\Models\Agree;
use App\Models\Incoming;
use App\Models\Outcoming;
use App\Models\OutgoingSide;
use App\Models\Diary;
use App\Models\DiaryState;
use App\Models\OutcomingsGreetines;
use App\Models\Category;
use App\Models\MediaFile;
use App\Models\ArticlesImage;

use App\Models\News;
use App\Models\Article;
use App\Models\ArticlesDetial;
use App\Models\Denouncement;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Validator;
use File;
use App\Traits\AttachFilesTrait;
use App\Traits\UploadMultiImagesTrait;

class DocumentationRepository implements DocumentationRepositoryInterface
{

    use UploadMultiImagesTrait;

    public function index()
    {
        $data['Agrees'] = Agree::all();
    
        $data['Responsibles'] = User::all();
        $data['Supervisors'] = User::all();
        $data['Commissioners'] = User::all();
        $data['Categories'] = Category::all();
        $data['Diarys'] = Diary::all();
        $data['DiaryStates'] = DiaryState::all();
        $data['OutgoingSides'] = OutgoingSide::all();
        return view('admin.documentations.index', $data);
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

                    $news = News::findorFail($request->news_id);
                    $news->title = ['en' => $request->title_ens, 'ar' => $request->title_ars];
                    $news->details = ['en' => $request->details_ens, 'ar' => $request->details_ars];
                    // $news->ready = $ready;
                    $news->date = date('Y-m-d');
                    $news->type = $request->types;
                    $news->url_link = $request->videos;
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

        // foreach($TasksMasters  as $TasksMaster)
        // {
        //     $TasksMaster->supervisors->name;
        //     $TasksMaster->taskdegrees->name;
        // }

        return $News;

    }

    public function getArticalById($id)
    {

        $TasksMasters =  Article::where('id',$id)->get();
       

        $data['News'] = Article::with('category')->where('id',$id)->get();
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
                             $title_ar  = $request->$title_ar;
                             $title_en  = $request->$title_en;
                             $details_ar  = $request->$details_ar;
                             $details_en  = $request->$details_en;
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
                            $ArticlesDetials->save();

                            if ($request->hasFile('images'.$x)) 
                            {
                                return response()->json(
                                    [
                                        'status' => true,
                                        'username' => 'modhi',
                                        'slug' => 'hellllo',
                                        
                                    ]
                                );
                                
                                // $file      = $request->file('images'.$x);
                                // $slug = $request->slug;
                                // $id = $request->id;
                                // $folder = $request->folder;
                                // $page = $request->page;
                                // $date = date('Y-m-d');
                                // $name = $date . rand() . '.' . $file->getClientOriginalExtension();
                                // $file->storeAs('attachments/'.$folder.'/'.$request->slug.'/images', $name,'upload_attachments');

                                $file      = $request->file('images'.$x);
                                $slug = $request->slug;
                                $id = $request->id;
                                $folder = $request->folder;
                                $page = $request->page;
                                $date = date('Y-m-d');
                                $name = $date . rand() . '.' . $file->getClientOriginalExtension();
                                $file->storeAs('attachments/'.$folder.'/'.$request->slug.'/images', $name,'upload_attachments');
                              
                                $ArticlesImages = new ArticlesImage();
                                $ArticlesImages->filename = $name;
                                $ArticlesImages->imageable_id = $id;
                                $ArticlesImages->subart_id = $ArticlesDetials->id;
                                $ArticlesImages->page = $page;
                                $ArticlesImages->type = 1;
                                $ArticlesImages->save();

                                // ArticlesImage::updateOrCreate([
                                //     'filename' =>  $name,
                                //     'imageable_id' => $id,
                                //     'subart_id' => $ArticlesDetials->id,
                                //     'page' => $page,
                                //     'type' =>1,
                                //         ]);
                            }
                             
                            
                         }
                         
                    }

                        // if ($request->hasFile('images0'))    
                        //     {
                                // ArticlesImage::insert($insert);
                            // }
                    // $x = 0;
                    // $insert[$x]['title'] = ['en' => '$title_en', 'ar' => '$title_ar'];
                    // $insert[$x]['details'] = ['en' => '$details_en', 'ar' => '$details_ar'];
                    // $insert[$x]['article_id'] = 7;
                    // $insert[$x]['video'] = '$video';
                    // $model = $request->model;
                   
                  
                    
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

                    $Articles = Article::findorFail($request->news_id);
                    $Articles->title = ['en' => $request->title_ens, 'ar' => $request->title_ars];
                    $Articles->details = ['en' => $request->details_ens, 'ar' => $request->details_ars];
                    // $news->ready = $ready;
                    $Articles->date = date('Y-m-d');
                    $Articles->type = $request->types;
                    $Articles->url_link = $request->videos;
                    $Articles->save();
                    $slug = $Articles->slug;

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

    public function getStoriesById($id)
    {

        $TasksMasters =  Storie::where('id',$id)->get();
       

        $data['Stories'] = Storie::with('category')->where('id',$id)->get();
        $data['Newsimage'] = MediaFile::where('imageable_id',$id)->get();
        return  $data ;
    }

    public function incomingsStore($request)
    {   
      
        try {       
                if ($request->request_type == 1) 
                {     
                    if(isset($request->outcoming_id) && ($request->type != 3 ))
                    {
                        $slug  = str_slug($request->title_ar);
                        $Incomings = new Incoming();
                        $Incomings->title = ['en' => $request->title_en, 'ar' => $request->title_ar];
                        $Incomings->details = ['en' => $request->details_en, 'ar' => $request->details_ar];
                        $Incomings->slug = $slug;
                        $Incomings->description = $request->description;
                        $Incomings->date = date('Y-m-d');
                        $Incomings->type = $request->type;
                        $Incomings->state = $request->state;
                        $Incomings->guidance_date = $request->delivery;
                        $Incomings->outcoming_id = $request->outcoming_id;
                        $Incomings->diary_no =  $request->diary_no;
                        $Incomings->incoming_no = $request->incoming_no;
                        $Incomings->from_side_id =  $request->from_side_id;
                        $Incomings->guidance_source =  $request->guidance_source;
                        $Incomings->guidance =  $request->guidance;
                        $Incomings->save();
                    }
                    else{
                        $slug  = str_slug($request->title_ar);
                        $Incomings = new Incoming();
                        $Incomings->title = ['en' => $request->title_en, 'ar' => $request->title_ar];
                        $Incomings->details = ['en' => $request->details_en, 'ar' => $request->details_ar];
                        $Incomings->slug = $slug;
                        $Incomings->description = $request->description;
                        $Incomings->date = date('Y-m-d');
                        $Incomings->type = $request->type;
                        $Incomings->state = $request->state;
                        $Incomings->guidance_date = $request->delivery;
                        $Incomings->incoming_no = $request->incoming_no;
                        // $Incomings->outcoming_id = $request->outcoming_id;
                        $Incomings->from_side_id =  $request->from_side_id;
                        $Incomings->diary_no =  $request->diary_no;
                        $Incomings->guidance_source =  $request->guidance_source;
                        $Incomings->guidance =  $request->guidance;
                        // $Incomings->to_side_id = 1;
                        $Incomings->save();
                    }
                   
                    return response()->json(
                        [
                            'status' => true,
                            'username' => 'modhi',
                            'slug' => $slug,
                            'id' => $Incomings->id,
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
            return response()->json(
                [
                    'status' => false,
                    'username' => 'modhi',
                    'error' => $e->getMessage(),
                ]
            );
        
        }
    }
   
    public function incomingsShow()
    {
        $Incomings = Incoming::with('fromsides')->where('select',1)->latest()->take(6)->get();
        return $Incomings;

    }

    public function updateStories($request)
    {        
        
        try {       
                if ($request->request_type == 1) 
                {

                    $Stories = Storie::findorFail($request->story_id);
                    $Stories->title = ['en' => $request->title_ens, 'ar' => $request->title_ars];
                    $Stories->details = ['en' => $request->details_ens, 'ar' => $request->details_ars];
                    // $news->ready = $ready;
                    $Stories->date = date('Y-m-d');
                    $Stories->type = $request->types;
                    $Stories->url_link = $request->videos;
                    $Stories->save();
                    $slug = $Stories->slug;

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

    public function outcomingsStore($request)
    {   
      
        try {       
                if ($request->request_type == 1) 
                {     
                    if(isset($request->incoming_id) && ($request->type != 4 ))
                    {
                        $slug  = str_slug($request->title_ar);
                        $Outcomings = new Outcoming();
                        $Outcomings->title = ['en' => $request->title_en, 'ar' => $request->title_ar];
                        $Outcomings->details = ['en' => $request->details_en, 'ar' => $request->details_ar];
                        $Outcomings->slug = $slug;
                        $Outcomings->description = $request->description;
                        $Outcomings->greetiness = $request->greetiness;
                        $Outcomings->date = date('Y-m-d');
                        $Outcomings->type = $request->type;
                        $Outcomings->state = $request->state;
                        $Outcomings->outcoming_no = $request->outcoming_no;
                        $Outcomings->delivery = $request->delivery;
                        // $Outcomings->incoming_id = $incoming_id;
                        // $Outcomings->from_side_id =1;
                        $Outcomings->to_side_id =  $request->to_side_id;
                        $Outcomings->save();
                    }
                    else{
                        $slug  = str_slug($request->title_ar);
                        $Outcomings = new Outcoming();
                        $Outcomings->title = ['en' => $request->title_en, 'ar' => $request->title_ar];
                        $Outcomings->details = ['en' => $request->details_en, 'ar' => $request->details_ar];
                        $Outcomings->slug = $slug;
                        $Outcomings->description = $request->description;
                        $Outcomings->greetiness = $request->greetiness;
                        $Outcomings->date = date('Y-m-d');
                        $Outcomings->type = $request->type;
                        $Outcomings->state = $request->state;
                        $Outcomings->outcoming_no = $request->outcoming_no;
                        $Outcomings->delivery = $request->delivery;
                        $Outcomings->incoming_id = $request->incoming_id;
                        // $Outcomings->from_side_id = 1;
                        $Outcomings->to_side_id = $request->to_side_id;
                        $Outcomings->save();
                    }

                    if (isset($request->TotalFiles) && ($request->TotalFiles != 0)) 
                    {
                        // $len = $request->TotalFiles - 1;
                        $len = $request->TotalFiles;
        
                    for ($x = 0; $x < $len; $x++) 
                    {
            
                       
                             $to_side_id_gre = 'to_side_id_gre'.$x;
                             $delivery_gre = 'delivery_gre'.$x;

                             $to_side_id_gre  = $request->$to_side_id_gre;
                             $delivery_gre  = $request->$delivery_gre;

                            $OutcomingsGreetiness = new OutcomingsGreetines();
                            $OutcomingsGreetiness->outcoming_id = $Outcomings->id;                      
                            $OutcomingsGreetiness->to_side_id = $to_side_id_gre;
                            $OutcomingsGreetiness->delivery = $delivery_gre;
                            $OutcomingsGreetiness->save();
                         }}
                   
                    return response()->json(
                        [
                            'status' => true,
                            'username' => 'modhi',
                            'slug' => $slug,
                            'id' => $Outcomings->id,
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
            return response()->json(
                [
                    'status' => false,
                    'username' => 'modhi',
                    'error' => $e->getMessage(),
                ]
            );
        
        }
    }
   
    public function outcomingsShow()
    {
        $Outcomings = Outcoming::with('tosides')->where('select',1)->latest()->take(6)->get();
        return $Outcomings;

    }

    public function sideStore($request)
    {   
      
        try {       
                if ($request->request_type == 1) 
                {     
                    if ($request->side_primary == 1) 
                    { 
                        $slug  = str_slug($request->name_ar);
                            $OutgoingSides = new OutgoingSide();
                            $OutgoingSides->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
                            $OutgoingSides->slug = $slug;
                            $OutgoingSides->save();
                        
                            if ($request->hasFile('images')) 
                            {                               
                                $file      = $request->file('images');
                                $slug = $OutgoingSides->slug;
                                $id = $OutgoingSides->id;
                                $folder = $request->folder;
                                $page = $request->page;
                                // $path = $file->store('public/images');
                                $date = date('Y-m-d');
                                $name = $date . rand() . '.' . $file->getClientOriginalExtension();
                                // $name = $file->getClientOriginalName();
                                $file->storeAs('attachments/'.$folder.'/'.$request->slug.'/images', $name,'upload_attachments');
            
                                $OutgoingSide = OutgoingSide::findorFail($id);
                                $OutgoingSide->image = $name;
                                $OutgoingSide->path = 'attachments/'.$folder.'/'.$slug.'/images';
                                $OutgoingSide->save();            
                        
                   
                            }

                        }
                    if ($request->sub_side == 2) 
                    {     
                            $slug = $request->subname_ar;
                            $SubSides = new OutgoingSide();
                            $SubSides->name = ['en' => $request->subname_en, 'ar' => $request->subname_ar];
                            $SubSides->slug = $slug;
                            // $SubSides->state = $slug;
                            $SubSides->type = 2;
                            $SubSides->side_id = $OutgoingSides->id;
                            $SubSides->save();

                            if ($request->hasFile('images')) 
                            {                               
                                $file      = $request->file('images');
                                $slug = $SubSides->slug;
                                $id = $OutgoingSides->id;
                                $folder = $request->folder;
                                $page = $request->page;
                                // $path = $file->store('public/images');
                                $date = date('Y-m-d');
                                $name = $date . rand() . '.' . $file->getClientOriginalExtension();
                                // $name = $file->getClientOriginalName();
                                $file->storeAs('attachments/'.$folder.'/'.$request->slug.'/images', $name,'upload_attachments');
            
                                $SubSides = SubSides::findorFail($id);
                                $SubSides->image = $name;
                                $SubSides->path = 'attachments/'.$folder.'/'.$slug.'/images';
                                $SubSides->save();            
                        
                   
                            }

                    }

                    elseif ($request->sub_side == 3) 
                    {     
                            $slug  = str_slug($request->subname_ar);
                            $SubSides = new OutgoingSide();
                            $SubSides->name = ['en' => $request->subname_en, 'ar' => $request->subname_ar];
                            $SubSides->slug = $slug;
                            // $SubSides->state = $slug;
                            $SubSides->type = 2;
                            $SubSides->side_id = $request->side_id;
                            $SubSides->save();

                            if ($request->hasFile('images')) 
                            {                               
                                $file      = $request->file('images');
                                $slug = $SubSides->slug;
                                $id = $OutgoingSides->id;
                                $folder = $request->folder;
                                $page = $request->page;
                                // $path = $file->store('public/images');
                                $date = date('Y-m-d');
                                $name = $date . rand() . '.' . $file->getClientOriginalExtension();
                                // $name = $file->getClientOriginalName();
                                $file->storeAs('attachments/'.$folder.'/'.$request->slug.'/images', $name,'upload_attachments');
            
                                $SubSides = SubSides::findorFail($id);
                                $SubSides->image = $name;
                                $SubSides->path = 'attachments/'.$folder.'/'.$slug.'/images';
                                $SubSides->save();            
                        
                   
                            }

                    }



                        return response()->json(
                            [
                                'status' => true,
                                'username' => 'modhi',
                                'Done' => 'All Success',
                            ]
                        );  
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

    public function sidesShow()
    {
        $OutgoingSides = OutgoingSide::where('select',1)->latest()->take(6)->get();
        return $OutgoingSides;

    }

    public function incoutquery($request)
    {
        // $Incomings = Incoming::findorFail(1);
                       
        //                 $Incomings->description = $request->title_ar;
                       
        //                 // $Incomings->to_side_id = 1;
        //                 $Incomings->save();

      
        $mbsql = array('select' => 1 );

        if(isset($request->from_side_id) && ($request->from_side_id <> ""))
        {  
            // $from_side_id = array('from_side_id' => $request->from_side_id );
            $from_side_id = ['from_side_id','=' , $request->from_side_id ];
            $mbsql = Arr::prepend($mbsql ,$from_side_id );
        }
       
        if(isset($request->state) && ($request->state <> ""))
        {  
            $state = ['state','=' , $request->state ];
            $mbsql = Arr::prepend($mbsql ,$state );
        }

        if(isset($request->type) && ($request->type <> ""))
        {  
            $type = ['type','=' , $request->state ];
            $mbsql = Arr::prepend($mbsql ,$type );
        }

        if(isset($request->diary_no) && ($request->diary_no <> ""))
        {  
            $diary_no = ['diary_no','=' , $request->diary_no ];
            $mbsql = Arr::prepend($mbsql ,$diary_no );
        }

        if(isset($request->outcoming_id) && ($request->outcoming_id <> ""))
        {  
            $outcoming_id = ['outcoming_id','=' , $request->outcoming_id ];
            $mbsql = Arr::prepend($mbsql ,$outcoming_id );
        }
       
        if(isset($request->title_ar) && ($request->title_ar <> ""))
        {  
            $title_ar = ['title','LIKE', '%'.$request->title_ar.'%' ];
            $mbsql = Arr::prepend($mbsql ,$title_ar );
        }

        if(isset($request->title_en) && ($request->title_en <> ""))
        {  
            $title_en = ['title','LIKE', '%'.$request->title_en.'%' ];
            $mbsql = Arr::prepend($mbsql ,$title_en );
        }
       
        if(isset($request->details_ar) && ($request->details_ar <> ""))
        {  
            $details_ar = ['details','LIKE', '%'.$request->details_ar.'%' ];
            $mbsql = Arr::prepend($mbsql ,$details_ar );
        }

        if(isset($request->details_en) && ($request->details_en <> ""))
        {  
            $details_en = ['details','LIKE', '%'.$request->details_en.'%' ];
            $mbsql = Arr::prepend($mbsql ,$details_en );
        }
        
        if(isset($request->description) && ($request->description <> ""))
        {  
            $description = ['description','LIKE', '%'.$request->description.'%' ];
            $mbsql = Arr::prepend($mbsql ,$description );
        }

        if(isset($request->guidance) && ($request->guidance <> ""))
        {  
            $guidance = ['guidance','LIKE', '%'.$request->guidance.'%' ];
            $mbsql = Arr::prepend($mbsql ,$guidance );
        }

        if(isset($request->guidance_date) && ($request->guidance_date <> ""))
        {  
            $guidance_date = ['guidance_date','=' , $request->guidance_date ];
            $mbsql = Arr::prepend($mbsql ,$guidance_date );
        }

        if(isset($request->from_date) && ($request->from_date <> "") && isset($request->to_date) && ($request->to_date <> ""))
        {  
            $from_date = ['outcoming_id','=' , $request->outcoming_id ];
            // ->whereBetween('points', [1, 150])
            $mbsql = Arr::prepend($mbsql ,$from_date );
        }
        
      
        // $mb = ['select','=' , 1];
        // $from_side_id = Arr::prepend($from_side_id ,['select'=> 2 ] );

        // $from_side_id = Arr::prepend($from_side_id ,$state );
        
        // $from_side_id = Arr::prepend($from_side_id ,$title_ar );
        
        // $mb = array();

        // return $from_side_id;
        // return $mbsql;
        $sql = array(
            $mbsql,
             );
        $incoutquery = Incoming::with('fromsides')->where(
            [
            
               $sql,
                
                ])->latest()->get();
       
        return $incoutquery;

    }

    public function select_outcoming_no()
    {
        $OutcomingID = Outcoming::orderBy('outcoming_no','desc')->value('outcoming_no');

            if (is_null($OutcomingID))
            {
                $OutcomingID =  0;
            }
            else
            {
                $OutcomingID;
            }
            $OutcomingID++;
            return $OutcomingID;
    }

    public function select_incoming_no()
    {
        $IncomingID = Incoming::orderBy('incoming_no','desc')->value('incoming_no');

            if (is_null($IncomingID))
            {
                $IncomingID =  0;
            }
            else
            {
                $IncomingID;
            }
            $IncomingID++;
            return $IncomingID;
    }
   
}
