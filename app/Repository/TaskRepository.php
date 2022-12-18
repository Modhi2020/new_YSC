<?php

namespace App\Repository;

use App\Models\Agree;
use App\Models\TasksType;
use App\Models\TaskState;
use App\Models\TasksMaster;
use App\Models\TasksDetail;
use App\Models\TaskDegree;
use App\Models\TaskFile;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Validator;
use File;
use App\Traits\AttachFilesTrait;

class TaskRepository implements TaskRepositoryInterface
{

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
        return view('admin.tasks.index', $data);
    }

    public function create()
    {
       // $data['Exchanges'] = Exchange::where('currency_id','<>',1)->get();
        $data['Currency'] = Currency::where('id','<>',1)->get();
        $data['Schools'] = School::all();
        $data['academicYears'] = Academic_year::where('default_academicYear',1)->first();
        return view('pages.Exchanges.create', $data);
    }

    public function store($request)
    {        
        DB::beginTransaction();
        
        try {       
                if ($request->request_type == 1) 
                {
                    $slug  = str_slug($request->title_ar);
                    $TasksMasters = new TasksMaster();
                    $TasksMasters->title = ['en' => $request->title_en, 'ar' => $request->title_ar];
                    $TasksMasters->details = ['en' => $request->details_en, 'ar' => $request->details_ar];
                    $TasksMasters->slug = $slug;
                    $TasksMasters->notes = $request->notes;
                    $TasksMasters->date = date('Y-m-d');
                    $TasksMasters->supervisor_id = $request->supervisor_id;
                    $TasksMasters->type = $request->type;
                    $TasksMasters->state = $request->state;
                    $TasksMasters->degree = $request->degree;
                    $TasksMasters->url_link = $request->video;
                    $TasksMasters->save();
                    
                    $len = $request->len;
                    $commissioners = $request->commissioner_id;
                    $beginnings = $request->beginning;
                    $deadlines = $request->deadline;
                    $sub_notes = $request->sub_notes;
                  
                    for($i = 0; $i < $len; $i++)
                    {
                        TasksDetail::updateOrCreate([
                            'task_id' => $TasksMasters->id,
                            'agree' => 2,
                            'notes' => $sub_notes[$i],
                            'commissioner_id' => $commissioners[$i],
                            // 'beginning' => date('Y-m-d'),
                            // 'deadline' => date('Y-m-d'),
                            'beginning' => $beginnings[$i],
                            'deadline' => $deadlines[$i],
                                ]);
                       
                    }
                   

                    DB::commit(); // insert data
                    return response()->json(
                        [
                            'status' => true,
                            'username' => 'modhi',
                            'slug' => $slug,
                            'id' => $TasksMasters->id,
                            // 'file' =>   urldecode($request->photos) ,
                        ]
                    );
                           
                }
                else 
                {
                   
                }

                
                    
           
        }
        catch (\Exception $e) {
            DB::rollback();
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
        // return response()->json(['success'=>'Ajax Multiple fIle has been uploaded']);
       $validatedData = $request->validate([
        // 'files' => 'required',
        'images.*' => 'mimes:jpeg,png,jpg,gif'
        ]);
 
        if($request->TotalFiles > 0)
        {
                
           for ($x = 0; $x < $request->TotalFiles; $x++) 
           {
 
               if ($request->hasFile('images'.$x)) 
                {
                    $file      = $request->file('images'.$x);
                    $slug = $request->slug;
                    $id = $request->id;
                    // $path = $file->store('public/images');
                    $name = rand() . '.' . $file->getClientOriginalExtension();
                    // $name = $file->getClientOriginalName();
                    $file->storeAs('attachments/tasks/'.$request->slug.'/images', $file->getClientOriginalName(),'upload_attachments');
 
                    $insert[$x]['filename'] = $name;
                    $insert[$x]['imageable_id'] = $id;
                    $insert[$x]['type'] = 1;
                }
           }
 
           TaskFile::insert($insert);
 
            return response()->json(['success'=>'Ajax Multiple images has been uploaded']);
 
        }
        else
        {
           return response()->json(["message" => "Please try again."]);
        }
 
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

        $TasksMasters =  TasksMaster::where('id',$id)->get();
       

        // foreach($TasksMasters as $TasksMaster)
        // {
        //     $TasksMaster->tasksTypes->name;
        //     $TasksMaster->supervisors->name;
        // }

        // $TasksMasters = TasksMaster::latest()->take(6)->get();

        foreach($TasksMasters  as $TasksMaster)
        {
            $TasksMaster->taskstates->name;
            $TasksMaster->supervisors->name;
            $TasksMaster->taskdegrees->name;
            $TasksMaster->taskstypes->name;
          
            $TasksMaster->agrees->name;
        }

        // return $TasksMasters;
        
        $data['TasksMasters']  = $TasksMasters;
        $data['TasksDetails']  = TasksDetail::with('commissioners')->where('task_id',$id)->get();
        $data['counts']  = TasksDetail::with('commissioners')->where('task_id',$id)->count();
        return  $data ;
    }

    public function update($request)
    {        
        DB::beginTransaction();
        
        try {       
                if ($request->request_type == 1) 
                {
                    //  $slug  = str_slug($request->title_ar);
                    $TasksMasters = TasksMaster::findorFail($request->task_id);
                    $TasksMasters->title = ['en' => $request->title_ens, 'ar' => $request->title_ars];
                    $TasksMasters->details = ['en' => $request->details_ens, 'ar' => $request->details_ars];
                    // $TasksMasters->slug = $slug;
                    $TasksMasters->notes = $request->notess;
                    // $TasksMasters->date = date('Y-m-d');
                    $TasksMasters->results = ['en' => $request->results_ens, 'ar' => $request->results_ars];
                    $TasksMasters->supervisor_id = $request->supervisor_ids;
                    $TasksMasters->type = $request->types;
                    $TasksMasters->state = $request->states;
                    $TasksMasters->degree = $request->degrees;
                    $TasksMasters->url_link = $request->videos;
                    $TasksMasters->save();
                    
                    $len = $request->len;
                    $commissioners = $request->commissioner_ids;
                    $beginnings = $request->beginnings;
                    $deadlines = $request->deadlines;
                    $sub_notes = $request->sub_notess;
                    $com_results_ars = $request->com_results_ars;
                    $com_results_ens = $request->com_results_ens;
                    $task_det_id = $request->task_det_id;

                    for($i = 0; $i < $len; $i++)
                    {
                        TasksDetail::where('id',$task_det_id[$i])->update([
                            'notes' => $sub_notes[$i],
                            'commissioner_id' => $commissioners[$i],
                            'com_results' =>  ['en' => $com_results_ens[$i], 'ar' => $com_results_ars[$i]],
                            // 'beginning' => date('Y-m-d'),
                            // 'deadline' => date('Y-m-d'),
                            'beginning' => $beginnings[$i],
                            'deadline' => $deadlines[$i],
                                ]);
                       
                    }
                   

                    DB::commit(); // insert data
                    return response()->json(
                        [
                            'status' => true,
                            'id' => '1',
                            'username' => 'modhi',
                            // 'file' =>   urldecode($request->photos) ,
                        ]
                    );
                           
                }
                else 
                {
                    Exchange::where('currency_id',1)->where('date',$request->date)->where('school_id', $request->school_id)
                    ->where('academic_year_id',$acadimicYears)->update([
                        'date' => $request->date,
                        'amount' => 1,
                        'currency_id' => 1,
                        'notes' => '.',
                        'school_id' => $request->school_id,
                        'academic_year_id' => $acadimicYears,
                            ]);

                            DB::commit(); // insert data
                            toastr()->success(trans('messages.success'));
                            return redirect()->route('Students.create');
                }

                
                    
           
        }
        catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $TasksMasters = TasksMaster::findOrFail($id);
            $TasksMasters->select = 0;
            $TasksMasters->save();

            TasksDetail::where('task_id',$id)->update([
                'select' => 0,
                    ]);

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

    public function TasksShow()
    {
        $TasksMasters = TasksMaster::where('select',1)->latest()->take(6)->get();

        foreach($TasksMasters  as $TasksMaster)
        {
            $TasksMaster->supervisors->name;
            $TasksMaster->taskdegrees->name;
        }

        return $TasksMasters;

    }

   
}
