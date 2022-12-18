<?php

namespace App\Repository;

use App\Models\JobType;
use App\Models\Program;
use App\Models\Category;
use App\Models\MediaFile;
use App\Models\Opportunity;

use App\Models\Preacher;
use App\Models\Mosque;
use App\Models\Requirement;

use App\Models\LogisticSupport;
use App\Models\Directorate;
use App\Models\Region;
use App\Models\SessionType;
use App\Models\City;
use App\Models\CorrectAnswer;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Validator;
use File;
use App\Traits\AttachFilesTrait;
use App\Traits\UploadMultiImagesTrait;

class NeedRepository implements NeedRepositoryInterface
{

    use UploadMultiImagesTrait;

    public function index()
    {
    
        $data['muzzins'] = Preacher::where('type',5)->where('ready',1)->where('select',1)->latest()->get();
        $data['preachers'] = Preacher::where('type',4)->where('ready',1)->where('select',1)->latest()->get();
        $data['imams'] = Preacher::where('type',3)->where('ready',1)->where('select',1)->latest()->get();
        $data['LogisticSupports'] = LogisticSupport::where('ready',1)->where('select',1)->latest()->get();
        $data['Directorates'] = Directorate::all();
        $data['Regions'] = Region::where('ready',1)->where('select',1)->latest()->get();
        $data['Authors'] = User::all();
        $data['Categories'] = Category::all();
        $data['JobTypes'] = JobType::all();
        $data['SessionTypes'] = SessionType::all();
        $data['CorrectAnswers'] = CorrectAnswer::all();
        $data['Cities'] = City::all();
        $data['Opportunities'] = Opportunity::latest()->get();
        return view('admin.needs.index', $data);
    }

    public function create()
    {
      
    }

    public function libraryStore($request)
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
                    $Libraries = new Library();
                    $Libraries->title = ['en' => $request->title_en, 'ar' => $request->title_ar];
                    $Libraries->details = ['en' => $request->details_en, 'ar' => $request->details_ar];
                    $Libraries->slug = $slug;
                    $Libraries->ready = $ready;
                    $Libraries->date = date('Y-m-d');
                    // $Libraries->type = $request->type;
                    $Libraries->url_link = $request->video;
                    $Libraries->save();
                  
                    return response()->json(
                        [
                            'status' => true,
                            'username' => 'modhi',
                            'slug' => $slug,
                            'id' => $Libraries->id,
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

    public function librariesShow()
    {
        $Libraries = Library::where('select',1)->latest()->take(6)->get();

        // foreach($TasksMasters  as $TasksMaster)
        // {
        //     $TasksMaster->supervisors->name;
        //     $TasksMaster->taskdegrees->name;
        // }

        return $Libraries;

    }

    public function opportunitiesStore($request)
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
                    $Opportunitys = new Opportunity();
                    $Opportunitys->title = ['en' => $request->title_en, 'ar' => $request->title_ar];
                    $Opportunitys->details = ['en' => $request->details_en, 'ar' => $request->details_ar];
                    $Opportunitys->slug = $slug;
                    $Opportunitys->ready = $ready;
                    $Opportunitys->date = date('Y-m-d');
                    $Opportunitys->url_link = $request->video;
                 
                
                    if(isset($request->type))
                    {
                        $Opportunitys->type = $request->type;
                    }

                    if(isset($request->city_id))
                    {
                        $Opportunitys->city_id = $request->city_id;
                    }

                    if(isset($request->service_id))
                    {
                        $Opportunitys->service_id = $request->service_id;
                    }

                    if(isset($request->location_id))
                    {
                        $Opportunitys->location_id = $request->location_id;
                    }

                    if(isset($request->submit_method))
                    {
                        $Opportunitys->submit_method = $request->submit_method;
                    }
                   
                     
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

                    $Opportunitys->image = $imagename;
                    $Opportunitys->path = $path;
                    $Opportunitys->save();
                  
                    return response()->json(
                        [
                            'status' => true,
                            'username' => 'modhi',
                            'slug' => $slug,
                            'id' => $Opportunitys->id,
                            // 'file' =>   urldecode($request->photos) ,
                        ]
                    );
                           
                }
                else 
                {
                   
                }

                
                    
           
        }
        catch (\Exception $e) {
            return response()->json([
                'message'   => $request->errors()->all(),
                'class_name'  => 'alert-danger'
               ]);
        }
    }

    public function opportunitiesShow()
    {
        $Opportunitys = Opportunity::where('select',1)->latest()->take(6)->get();

        return $Opportunitys;

    }

    public function mosquesStore($request)
    {  
        
        try {   
            
            
            
                if ($request->request_type == 1) 
                {

                    return response()->json(
                        [
                            'status' => true,
                            'username' => 'modhi',
                        ]
                    );

                    if(isset($request->ready))
                    {
                        $ready = 1;
                    }
                    else{
                        $ready = 2;
                    }

               
                    $mosques = new Mosque();
                    $mosques->questions = ['en' => $request->questions_en, 'ar' => $request->questions_ar];
                    $mosques->frist_answer = ['en' => $request->frist_answer_en, 'ar' => $request->frist_answer_ar];
                    $mosques->second_answer = ['en' => $request->second_answer_en, 'ar' => $request->second_answer_ar];
                    $mosques->third_answer = ['en' => $request->third_answer_en, 'ar' => $request->third_answer_ar];
                    $mosques->fourth_answer = ['en' => $request->fourth_answer_en, 'ar' => $request->fourth_answer_ar];
                    // $mosques->slug = $slug;
                    $mosques->ready = $ready;
                    // $mosques->date = date('Y-m-d');
                  

                    if(isset($request->correct_answer))
                    {
                        $mosques->correct_answer = $request->correct_answer;
                    }
                    
                    if(isset($request->degree))
                    {
                        $mosques->degree = $request->degree;
                    }

                    $mosques->save();
                  
                    return response()->json(
                        [
                            'status' => true,
                            'username' => 'modhi',
                            'id' => $mosques->id,
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

    public function mosquesShow()
    {
        $mosques = mosque::where('select',1)->latest()->take(6)->get();

        return $mosques;

    }


    public function preachersStore($request)
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

                    $slug  = str_slug($request->name_ar);
                    $Preachers = new Preacher();
                    $Preachers->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
                    $Preachers->slug = $slug;
                    $Preachers->ready = $ready;
                    $Preachers->email = $request->email;
                    $Preachers->phone = $request->phone;
                    $Preachers->notes = $request->notes;
                
                    if(isset($request->type))
                    {
                        $Preachers->type = $request->type;
                    }
                   
                     
                    $Preachers->save();
                  
                    return response()->json(
                        [
                            'status' => true,
                            'username' => 'modhi',
                        ]
                    );
                           
                }
                else 
                {
                   
                }

                
                    
           
        }
        catch (\Exception $e) {
            return response()->json([
                'message'   => $request->errors()->all(),
                'class_name'  => 'alert-danger'
               ]);
        }
    }

    public function preachersShow()
    {
        $Preachers = Preacher::where('ready',1)->where('select',1)->latest()->take(6)->get();

        return $Preachers;

    }

    public function AssginmosquesToOpportunity($request)
    {
        $opportunity_id = $request->opportunity_id;  
        $len = $request->len;

        for($row =0; $row < $len; $row++)
        {
            mosquesOpportunity::updateOrCreate(
                [
                'opportunity_id' => $opportunity_id,
                'mosque_id' => $request->mosquesArray[$row],
                ]);
        }
        

         return response()->json(
            [
                'status' => true,
                'username' => 'modhi',
            ]
        );
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
}
