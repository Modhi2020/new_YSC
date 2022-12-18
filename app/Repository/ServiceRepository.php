<?php

namespace App\Repository;

use App\Models\Service;
use App\Models\Program;
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


use App\Models\Library;
use App\Models\Course;
use App\Models\Video;
use App\Models\Mysession;
use App\Models\Beneficiary;
use App\Models\SessionType;
use App\Models\City;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Validator;
use File;
use App\Traits\AttachFilesTrait;
use App\Traits\UploadMultiImagesTrait;

class ServiceRepository implements ServiceRepositoryInterface
{

    use UploadMultiImagesTrait;

    public function index()
    {
    
        $data['Responsibles'] = User::all();
        $data['Authors'] = User::all();
        $data['Categories'] = Category::all();
        $data['Services'] = Service::all();
        $data['SessionTypes'] = SessionType::all();
        $data['Cities'] = City::all();
        return view('admin.services.index', $data);
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

                    $slug  = str_slug($request->title_en);
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

    public function serviceStore($request)
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
                    $Services = new Service();
                    $Services->title = ['en' => $request->title_en, 'ar' => $request->title_ar];
                    $Services->details = ['en' => $request->details_en, 'ar' => $request->details_ar];
                    $Services->slug = $slug;
                    $Services->ready = $ready;
                    // $Services->date = date('Y-m-d');
                    // $Services->type = $request->type;
                
                    if(isset($request->city_id))
                    {
                        $Services->city_id = $request->city_id;
                    }

                    if(isset($request->video) && $request->video != '' )
                    {
                        $Services->url_link = $request->video;
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

                    $Services->image = $imagename;
                    $Services->path = $path;
                    $Services->save();
                  
                    return response()->json(
                        [
                            'status' => true,
                            'username' => 'modhi',
                            'slug' => $slug,
                            'id' => $Services->id,
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

    public function servicesShow()
    {
        $Services = Service::where('select',1)->latest()->take(6)->get();

        return $Services;

    }

    public function getServiceById($id)
    {

        $TasksMasters =  Service::where('id',$id)->get();
       

        $data['services'] = Service::where('id',$id)->get();
        $data['Newsimage'] = MediaFile::where('imageable_id',$id)->get();
        return  $data ;
    }

    public function updateServices($request)
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

                    $Services = Service::findorFail($request->service_id);
                    $Services->title = ['en' => $request->sertitle_ens, 'ar' => $request->sertitle_ars];
                    $Services->details = ['en' => $request->serdetails_ens, 'ar' => $request->serdetails_ars];
                    $Services->ready = $ready;
                    $slug = $Services->slug;
                    // $Services->date = date('Y-m-d');
                    // $Services->type = $request->sertypes;

                    if(isset($request->city_id) && $request->city_id != '' )
                    {
                        $Services->city_id = $request->city_id;
                    }

                    if(isset($request->servideos) && $request->servideos != '' )
                    {
                        $Services->url_link = $request->servideos;
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
                        $imagename = $Services->image;
                        $path = $Services->path;
                    }

                    $Services->image = $imagename;
                    $Services->path = $path;
                    $Services->save();
                  

                    return response()->json(
                        [
                            'status' => true,
                            'username' => 'modhi',
                            'slug' => $slug,
                            'id' => $Services->id,
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

    public function destroyServices($id)
    {
        try {
            $Services = Service::findOrFail($id);
            $Services->select = 0;
            $Services->save();

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

    public function programsStore($request)
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
                    $Programs = new Program();
                    $Programs->title = ['en' => $request->title_en, 'ar' => $request->title_ar];
                    $Programs->details = ['en' => $request->details_en, 'ar' => $request->details_ar];
                    $Programs->slug = $slug;
                    $Programs->ready = $ready;
                    // $Programs->date = date('Y-m-d');
                  

                    if(isset($request->service_id))
                    {
                        $Programs->service_id = $request->service_id;
                    }
                    
                    if(isset($request->city_id))
                    {
                        $Programs->city_id = $request->city_id;
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
                        $path = 'attachments/programs';
                    }

                    $Programs->image = $imagename;
                    $Programs->path = $path;

                    $Programs->save();
                  
                    return response()->json(
                        [
                            'status' => true,
                            'username' => 'modhi',
                            'slug' => $slug,
                            'id' => $Programs->id,
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

    public function programsShow()
    {
        $programs = Program::where('select',1)->latest()->take(6)->get();

        return $programs;

    }

    public function getProgramsById($id)
    {

        $TasksMasters =  Program::where('id',$id)->get();
       

        $data['programs'] = Program::where('id',$id)->get();
        $data['Newsimage'] = MediaFile::where('imageable_id',$id)->get();
        return  $data ;
    }

    public function updatePrograms($request)
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

                    $Programs = Program::findorFail($request->program_id);
                    $Programs->title = ['en' => $request->protitle_ens, 'ar' => $request->protitle_ars];
                    $Programs->details = ['en' => $request->prodetails_ens, 'ar' => $request->prodetails_ars];
                    $Programs->ready = $ready;
                    $slug = $Programs->slug;
                    // $Programs->date = date('Y-m-d');
                    // $Programs->type = $request->protypes;

                    if(isset($request->city_id) && $request->city_id != '' )
                    {
                        $Programs->city_id = $request->city_id;
                    }

                    if(isset($request->provideos) && $request->provideos != '' )
                    {
                        $Programs->url_link = $request->provideos;
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
                        $imagename = $Programs->image;
                        $path = $Programs->path;
                    }
                    
                    $Programs->image = $imagename;
                    $Programs->path = $path;
                    $Programs->save();
              

                    return response()->json(
                        [
                            'status' => true,
                            'username' => 'modhi',
                            'slug' => $slug,
                            'id' => $Programs->id,
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

    public function destroyPrograms($id)
    {
        try {
            $Programs = Program::findOrFail($id);
            $Programs->select = 0;
            $Programs->save();

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



    public function mysessionsStore($request)
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
                    $Mysessions = new Mysession();
                    $Mysessions->title = ['en' => $request->title_en, 'ar' => $request->title_ar];
                    $Mysessions->details = ['en' => $request->details_en, 'ar' => $request->details_ar];
                    $Mysessions->slug = $slug;
                    $Mysessions->ready = $ready;
                    $Mysessions->start_time = $request->start_time;
                    $Mysessions->end_time = $request->end_time;

                    if(isset($request->type))
                    {
                        $Mysessions->type = $request->type;
                    }
                
                    if(isset($request->city_id))
                    {
                        $Mysessions->city_id = $request->city_id;
                    }

                    if(isset($request->service_id))
                    {
                        $Mysessions->service_id = $request->service_id;
                    }

                    if(isset($request->instructor_id))
                    {
                        $Mysessions->instructor_id = $request->instructor_id;
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

                    $Mysessions->image = $imagename;
                    $Mysessions->path = $path;
                    $Mysessions->save();
                  
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

    public function mysessionsShow()
    {
        $Mysessions = Mysession::where('select',1)->latest()->take(6)->get();

        return $Mysessions;

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
