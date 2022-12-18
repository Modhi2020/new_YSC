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
use App\Models\Service;
use App\Models\Program;

use App\Models\Library;
use App\Models\Course;
use App\Models\Video;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Validator;
use File;
use App\Traits\AttachFilesTrait;
use App\Traits\UploadMultiImagesTrait;

class LibraryRepository implements LibraryRepositoryInterface
{

    use UploadMultiImagesTrait;

    public function index()
    {

        $data['Responsibles'] = User::latest()->get();
        $data['Authors'] = User::latest()->get();
        $data['programs'] = Program::latest()->get();
        $data['Courses'] = Course::latest()->get();
        $data['Services'] = Service::latest()->get();
        $data['Categories'] = Category::latest()->get();
        return view('admin.libraries.index', $data);
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
                    $Libraries->type = 2;

                    if(isset($request->video) && $request->video != '' )
                    {
                        $Libraries->url_link = $request->video;
                    }

                    if(isset($request->author) && $request->author != '' )
                    {
                        $Libraries->author = $request->author;
                    }

                    if(isset($request->service_id) && $request->service_id != '' )
                    {
                        $Libraries->service_id = $request->service_id;
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

                    $Libraries->image = $imagename;
                    $Libraries->path = $path;
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
        $Libraries = Library::where('select',1)->where('type',2)->latest()->take(6)->get();

        // foreach($TasksMasters  as $TasksMaster)
        // {
        //     $TasksMaster->supervisors->name;
        //     $TasksMaster->taskdegrees->name;
        // }

        return $Libraries;

    }

    public function getLibraryById($id)
    {

        $data['libraries'] = Library::where('id',$id)->get();
        return  $data ;
    }

    public function updateLibraries($request)
    {        
        
        try {       
                if ($request->request_type == 1) 
                {
                    

                    if(isset($request->libreadys))
                    {
                        $ready = 1;
                    }
                    else{
                        $ready = 2;
                    }

                    $libraries = Library::findorFail($request->library_id);
                    $libraries->title = ['en' => $request->libtitle_ens, 'ar' => $request->libtitle_ars];
                    $libraries->details = ['en' => $request->libdetails_ens, 'ar' => $request->libdetails_ars];
                    $libraries->ready = $ready;
                    $slug = $libraries->slug;

                    if(isset($request->libvideos) && $request->libvideos != '' )
                    {
                        $libraries->url_link = $request->libvideos;
                    }

                    if(isset($request->libauthors) && $request->libauthors != '' )
                    {
                        $libraries->author = $request->libauthors;
                    }

                    if(isset($request->libservice_ids) && $request->libservice_ids != '' )
                    {
                        $libraries->service_id = $request->libservice_ids;
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
                        $imagename =  $libraries->image;
                        $path =  $libraries->path;
                    }

                    $libraries->image = $imagename;
                    $libraries->path = $path;
                    
                    $libraries->save();

                    return response()->json(
                        [
                            'status' => true,
                            'username' => 'modhi',
                            'slug' => $slug,
                            'id' => $libraries->id,
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

    public function destroylibrary($id)
    {
        try {
            $libraries = Library::findOrFail($id);
            $libraries->select = 0;
            $libraries->save();

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

    public function versionsStore($request)
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
                    $Libraries->type = 1;
                   
                    if(isset($request->video) && $request->video != '' )
                    {
                        $Libraries->url_link = $request->video;
                    }

                    if(isset($request->author) && $request->author != '' )
                    {
                        $Libraries->author = $request->author;
                    }

                    if(isset($request->service_id) && $request->service_id != '' )
                    {
                        $Libraries->service_id = $request->service_id;
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

                    $Libraries->image = $imagename;
                    $Libraries->path = $path;
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

    public function versionsShow()
    {
        $Libraries = Library::where('select',1)->where('type',1)->latest()->take(6)->get();

        return $Libraries;

    }

    public function getVersionById($id)
    {

        $data['versions'] = Library::where('id',$id)->get();
        return  $data ;
    }

    public function updateversions($request)
    {        
        
        try {       
                if ($request->request_type == 1) 
                {
                    

                    if(isset($request->verreadys))
                    {
                        $ready = 1;
                    }
                    else{
                        $ready = 2;
                    }

                    $versions = Library::findorFail($request->versions_id);
                    $versions->title = ['en' => $request->vertitle_ens, 'ar' => $request->vertitle_ars];
                    $versions->details = ['en' => $request->verdetails_ens, 'ar' => $request->verdetails_ars];
                    $versions->ready = $ready;
                    $slug = $versions->slug;

                    if(isset($request->vervideos) && $request->vervideos != '' )
                    {
                        $versions->url_link = $request->vervideos;
                    }

                    if(isset($request->verauthors) && $request->verauthors != '' )
                    {
                        $versions->author = $request->verauthors;
                    }

                    if(isset($request->verservice_ids) && $request->verservice_ids != '' )
                    {
                        $versions->service_id = $request->verservice_ids;
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
                        $imagename =    $versions->image;
                        $path =    $versions->path;
                    }

                    $versions->image = $imagename;
                    $versions->path = $path;
                    $versions->save();

                    return response()->json(
                        [
                            'status' => true,
                            'username' => 'modhi',
                            'slug' => $slug,
                            'id' => $versions->id,
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

    public function destroyversions($id)
    {
        try {
            $versions = Library::findOrFail($id);
            $versions->select = 0;
            $versions->save();

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


    public function coursesStore($request)
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
                    $Courses = new Course();
                    $Courses->title = ['en' => $request->title_en, 'ar' => $request->title_ar];
                    $Courses->details = ['en' => $request->details_en, 'ar' => $request->details_ar];
                    $Courses->slug = $slug;
                    $Courses->ready = $ready;
                    // $Courses->date = date('Y-m-d');
                    // $Courses->type = $request->type;
                    $Courses->url_link = $request->video;
                    $Courses->publisher = $request->publisher;

                    if(isset($request->service_id))
                    {
                        $Courses->service_id = $request->service_id;
                    }
                    if(isset($request->program_id))
                    {
                        $Courses->program_id = $request->program_id;
                    }
                    if(isset($request->publisher_id))
                    {
                        $Courses->publisher_id = $request->publisher_id;
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

                    $Courses->image = $imagename;
                    $Courses->path = $path;
                    $Courses->save();
                  
                    return response()->json(
                        [
                            'status' => true,
                            'username' => 'modhi',
                            'slug' => $slug,
                            'id' => $Courses->id,
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

    public function coursesShow()
    {
        $Courses = Course::where('select',1)->latest()->take(6)->get();

        return $Courses;

    }

    public function getCourseById($id)
    {

        $data['courses'] = Course::where('id',$id)->get();
        return  $data ;
    }

    public function updateCourses($request)
    {        
        
        try {       
                if ($request->request_type == 1) 
                {
                    

                    if(isset($request->correadys))
                    {
                        $ready = 1;
                    }
                    else{
                        $ready = 2;
                    }

                    $courses = Course::findorFail($request->course_id);
                    $courses->title = ['en' => $request->cortitle_ens, 'ar' => $request->cortitle_ars];
                    $courses->details = ['en' => $request->cordetails_ens, 'ar' => $request->cordetails_ars];
                    $courses->ready = $ready;
                    $slug = $courses->slug;
                   
                    if(isset($request->corvideos) && $request->corvideos != '' )
                    {
                        $courses->url_link = $request->corvideos;
                    }
                    if(isset($request->corpublishers) && $request->corpublishers != '' )
                    {
                        $courses->publisher = $request->corpublishers;
                    }
                    if(isset($request->corservice_ids) && $request->corservice_ids != '' )
                    {
                        $courses->service_id = $request->corservice_ids;
                    }
                    if(isset($request->corprogram_ids) && $request->corprogram_ids != '' )
                    {
                        $courses->program_id = $request->corprogram_ids;
                    }
                    if(isset($request->corpublisher_ids) && $request->corpublisher_ids != '' )
                    {
                        $courses->publisher_id = $request->corpublisher_ids;
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
                        $imagename = $courses->image;
                        $path = $courses->path;
                    }

                    $courses->image = $imagename;
                    $courses->path = $path;
                    $courses->save();
                   

                    return response()->json(
                        [
                            'status' => true,
                            'username' => 'modhi',
                            'slug' => $slug,
                            'id' => $courses->id,
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

    public function destroycourse($id)
    {
        try {
            $courses = Course::findOrFail($id);
            $courses->select = 0;
            $courses->save();

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



    public function videosStore($request)
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
                    $Videos = new Video();
                    $Videos->title = ['en' => $request->title_en, 'ar' => $request->title_ar];
                    $Videos->details = ['en' => $request->details_en, 'ar' => $request->details_ar];
                    $Videos->slug = $slug;
                    $Videos->ready = $ready;
                    $Videos->date = date('Y-m-d');
                    // $Videos->type = $request->type;

                    if(isset($request->course_id))
                    {
                        $Videos->course_id = $request->course_id;
                    }

                    if(isset($request->publisher_id))
                    {
                        $Videos->publisher_id = $request->publisher_id;
                    }

                    if(isset($request->publisher))
                    {
                        $Videos->publisher = $request->publisher;
                    }

                    if(isset($request->video))
                    {
                        $Videos->url_link = $request->video;
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

                    $Videos->image = $imagename;
                    $Videos->path = $path;

                    $Videos->save();
                  
                    return response()->json(
                        [
                            'status' => true,
                            'username' => 'modhi',
                            'slug' => $slug,
                            'id' => $Videos->id,
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

    public function videosShow()
    {
        $Videos = Video::where('select',1)->latest()->take(6)->get();

        return $Videos;

    }

    public function getVideosById($id)
    {

        $data['videos'] = Video::where('id',$id)->get();
        return  $data ;
    }

    public function updatevideos($request)
    {        
        
        try {       
                if ($request->request_type == 1) 
                {
                    

                    if(isset($request->vidreadys))
                    {
                        $ready = 1;
                    }
                    else{
                        $ready = 2;
                    }

                    $videos = Video::findorFail($request->videos_id);
                    $videos->title = ['en' => $request->vidtitle_ens, 'ar' => $request->vidtitle_ars];
                    $videos->details = ['en' => $request->viddetails_ens, 'ar' => $request->viddetails_ars];
                    $videos->ready = $ready;
                    $slug = $videos->slug;

                    if(isset($request->vidvideos) && $request->vidvideos != '' )
                    {
                        $videos->url_link = $request->vidvideos;
                    }

                    if(isset($request->vidpublishers) && $request->vidpublishers != '' )
                    {
                        $videos->publisher = $request->vidpublishers;
                    }

                    if(isset($request->vidpublisher_ids) && $request->vidpublisher_ids != '' )
                    {
                        $videos->publisher_id = $request->vidpublisher_ids;
                    }

                    if(isset($request->vidcourse_ids) && $request->vidcourse_ids != '' )
                    {
                        $videos->course_id = $request->vidcourse_ids;
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
                        $imagename =  $videos->image;
                        $path =  $videos->path;
                    }

                    $videos->image = $imagename;
                    $videos->path = $path;
                    $videos->save();

                    return response()->json(
                        [
                            'status' => true,
                            'username' => 'modhi',
                            'slug' => $slug,
                            'id' => $videos->id,
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

    public function destroyvideos($id)
    {
        try {
            $videos = Video::findOrFail($id);
            $videos->select = 0;
            $videos->save();

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

  


}
