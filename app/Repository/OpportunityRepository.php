<?php

namespace App\Repository;

use App\Models\Service;
use App\Models\Program;
use App\Models\TaskState;
use App\Models\TasksMaster;
use App\Models\TasksDetail;
use App\Models\SubmitMethod;
use App\Models\TaskFile;
use App\Models\Category;
use App\Models\MediaFile;
use App\Models\Opportunity;
use App\Models\Survey;
use App\Models\SurveysOpportunity;
use App\Models\OpportunityType;

use App\Models\Video;
use App\Models\Mysession;
use App\Models\Beneficiary;
use App\Models\SessionType;
use App\Models\City;
use App\Models\CorrectAnswer;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Validator;
use File;
use App\Traits\AttachFilesTrait;
use App\Traits\UploadMultiImagesTrait;

class OpportunityRepository implements OpportunityRepositoryInterface
{

    use UploadMultiImagesTrait;

    public function index()
    {
    
        $data['Responsibles'] = User::latest()->get();
        $data['Authors'] = User::latest()->get();
        $data['Categories'] = Category::latest()->get();
        $data['Services'] = Service::latest()->get();
        $data['programs'] = Program::latest()->get();
        $data['SubmitMethods'] = SubmitMethod::latest()->get();
        $data['SessionTypes'] = SessionType::latest()->get();
        $data['OpportunityTypes'] = OpportunityType::latest()->get();
        $data['CorrectAnswers'] = CorrectAnswer::latest()->get();
        $data['Cities'] = City::all();
        $data['Opportunities'] = Opportunity::latest()->get();
        return view('admin.opportunities.index', $data);
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

                    $slug  = str_slug($request->title_en);
                    $Opportunitys = new Opportunity();
                    $Opportunitys->title = ['en' => $request->title_en, 'ar' => $request->title_ar];
                    $Opportunitys->details = ['en' => $request->details_en, 'ar' => $request->details_ar];
                    $Opportunitys->slug = $slug;
                    $Opportunitys->ready = $ready;
                    $Opportunitys->date = date('Y-m-d');
                    $Opportunitys->start_time = $request->start_time;
                    $Opportunitys->end_time = $request->end_time;
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

                    if(isset($request->program_id))
                    {
                        $Opportunitys->program_id = $request->program_id;
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

    public function getOpportunityById($id)
    {

        $data['opportunities'] = Opportunity::where('id',$id)->get();
        return  $data ;
    }

    public function updateopportunities($request)
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

                    $opportunities = Opportunity::findorFail($request->opportunity_id);
                    $opportunities->title = ['en' => $request->opptitle_ens, 'ar' => $request->opptitle_ars];
                    $opportunities->details = ['en' => $request->oppdetails_ens, 'ar' => $request->oppdetails_ars];
                    $opportunities->ready = $ready;
                    $opportunities->start_time = $request->oppstart_times;
                    $opportunities->end_time = $request->oppend_times;
                    $slug = $opportunities->slug;
                    // $opportunities->date = date('Y-m-d');
                    // $opportunities->type = $request->opptypes;

                    if(isset($request->oppcity_ids) && $request->oppcity_ids != '' )
                    {
                        $opportunities->city_id = $request->oppcity_ids;
                    }

                    if(isset($request->oppvideos) && $request->oppvideos != '' )
                    {
                        $opportunities->url_link = $request->oppvideos;
                    }

                    if(isset($request->oppservice_ids))
                    {
                        $opportunities->service_id = $request->oppservice_ids;
                    }

                    if(isset($request->opptypes))
                    {
                        $opportunities->type = $request->opptypes;
                    }

                    if(isset($request->oppsubmit_methods))
                    {
                        $opportunities->submit_method = $request->oppsubmit_methods;
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
                        $imagename = $opportunities->image;
                        $path = $opportunities->path;
                    }

                    $opportunities->image = $imagename;
                    $opportunities->path = $path;
                    
                    $opportunities->save();
                   

                    return response()->json(
                        [
                            'status' => true,
                            'username' => 'modhi',
                            'slug' => $slug,
                            'id' => $opportunities->id,
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

    public function destroyopportunity($id)
    {
        try {
            $opportunities = Opportunity::findOrFail($id);
            $opportunities->select = 0;
            $opportunities->save();

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


    public function surveysStore($request)
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

               
                    $Surveys = new Survey();
                    $Surveys->questions = ['en' => $request->questions_en, 'ar' => $request->questions_ar];
                    $Surveys->first_answer = ['en' => $request->first_answer_en, 'ar' => $request->first_answer_ar];
                    $Surveys->second_answer = ['en' => $request->second_answer_en, 'ar' => $request->second_answer_ar];
                    $Surveys->third_answer = ['en' => $request->third_answer_en, 'ar' => $request->third_answer_ar];
                    $Surveys->fourth_answer = ['en' => $request->fourth_answer_en, 'ar' => $request->fourth_answer_ar];
                    // $Surveys->slug = $slug;
                    $Surveys->ready = $ready;
                    // $Surveys->date = date('Y-m-d');
                  

                    if(isset($request->correct_answer))
                    {
                        $Surveys->correct_answer = $request->correct_answer;
                    }
                    
                    if(isset($request->degree))
                    {
                        $Surveys->degree = $request->degree;
                    }

                    $Surveys->save();
                  
                    return response()->json(
                        [
                            'status' => true,
                            'username' => 'modhi',
                            'id' => $Surveys->id,
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

    public function surveysShow()
    {
        $Surveys = Survey::where('select',1)->latest()->take(6)->get();

        return $Surveys;

    }

    
    public function getSurveysById($id)
    {

        $data['surveys'] = Survey::where('id',$id)->get();
        return  $data ;
    }

    public function updatesurveys($request)
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

                    $surveys = Survey::findorFail($request->survey_id);
                    $surveys->questions = ['en' => $request->surquestions_ens, 'ar' => $request->surquestions_ars];
                    $surveys->first_answer = ['en' => $request->surfirst_answer_ens, 'ar' => $request->surfirst_answer_ars];
                    $surveys->second_answer = ['en' => $request->sursecond_answer_ens, 'ar' => $request->sursecond_answer_ars];
                    $surveys->third_answer = ['en' => $request->surthird_answer_ens, 'ar' => $request->surthird_answer_ars];
                    $surveys->fourth_answer = ['en' => $request->surfourth_answer_ens, 'ar' => $request->surfourth_answer_ars];
                    // $Surveys->slug = $slug;
                    $surveys->ready = $ready;
                    // $Surveys->date = date('Y-m-d');
                  

                    if(isset($request->surcorrect_answers))
                    {
                        $surveys->correct_answer = $request->surcorrect_answers;
                    }
                    
                    if(isset($request->degrees))
                    {
                        $surveys->degree = $request->surdegrees;
                    }

                    $surveys->save();
                    $slug = $surveys->slug;

                    return response()->json(
                        [
                            'status' => true,
                            'username' => 'modhi',
                            'slug' => $slug,
                            'id' => $surveys->id,
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

    public function destroysurvey($id)
    {
        try {
            $surveys = Survey::findOrFail($id);
            $surveys->select = 0;
            $surveys->save();

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
                    $Mysessions->type = $request->type;
                
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
                            'slug' => $slug,
                            'id' => $Mysessions->id,
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

    public function mysessionsShow()
    {
        $Mysessions = Mysession::where('select',1)->latest()->take(6)->get();

        return $Mysessions;

    }

    public function AssginSurveysToOpportunity($request)
    {
        $opportunity_id = $request->opportunity_id;  
        $len = $request->len;

        for($row =0; $row < $len; $row++)
        {
            SurveysOpportunity::updateOrCreate(
                [
                'opportunity_id' => $opportunity_id,
                'survey_id' => $request->surveysArray[$row],
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
