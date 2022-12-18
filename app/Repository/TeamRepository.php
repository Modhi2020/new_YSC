<?php

namespace App\Repository;

use App\Models\Team;
// use App\Models\City;

// use App\Models\Objective;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Validator;
use File;


class TeamRepository implements TeamRepositoryInterface
{



    public function index()
    {
        $data['Teams'] = Team::all();
        return view('admin.aboutus.index', $data);
    }

    public function create()
    {
        $data['Teams'] = Team::all();
        return view('admin.aboutus.create', $data);
    }


    public function store($request)
    {  
        
        try {     
            // return response()->json(
            //             [
            //                 'status' => false,
            //                 'username' => 'modhi',
                           
            //             ]
            //         );

                    if(isset($request->ready))
                    {
                        $ready = 1;
                    }
                    else{
                        $ready = 2;
                    }

                    $slug  = str_slug($request->name_ar);
                    $Teams = new Team();
                    $Teams->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
                    $Teams->occupation = $request->occupation;
                    $Teams->slug = $slug;
                    $Teams->ready = $ready;

                     
                    if ($request->hasFile('teamimg')) 
                    {
                        $file = $request->file('teamimg');
                        $folder = $request->folder;
                        $date = date('Y-m-d');
                        $name = $date . rand() . '.' . $file->getClientOriginalExtension();
                        $file->storeAs('attachments/'.$folder.'/'.$slug.'/images', $name,'upload_attachments');
                        // $imagename = $name;
                        $teamimg = 'attachments/'.$folder.'/'.$slug.'/images/'.$name;

                    }
                    else
                    {
                        $teamimg = 'attachments/teams/default.png';
                    
                    }

                    $Teams->teamimg = $teamimg;

                    $Teams->save();

                    return response()->json(
                        [
                            'status' => true,
                            'username' => 'modhi',
                           
                        ]
                    );  
                            
                Toastr::success('{{ trans("libraries_trans.save_detail") }}','{{ trans("libraries_trans.save_title") }}');
                return redirect()->route('admin.aboutus.index');
                  

          
        }
        catch (\Exception $e) {
            return response()->json(
                        [
                            'status' => false,
                            'username' => 'modhi',
                           
                        ]
                    );
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function teamsShow()
    {
        $Teams = Team::with('occupations')->where('select',1)->latest()->take(6)->get();
        return $Teams;

    }
    
    public function show($id)
    {

    }

    public function edit($id)
    {

        $data['teams'] = Team::where('id',$id)->get();
        return  $data ;
    }

    public function update($request)
    {        
        
        try {       
                if ($request->request_type == 1) 
                {
                    if(isset($request->teareadys))
                    {
                        $ready = 1;
                    }
                    else
                    {
                        $ready = 2;
                    }

                    $teams = Team::findorFail($request->team_id);
                    $teams->name = ['en' => $request->teaname_ens, 'ar' => $request->teaname_ars];
                    $teams->occupation = $request->teaoccupations;
                    $teams->ready = $ready;
                    $slug = $teams->slug;
                  
                    if(isset($request->teacity_ids))
                    {
                        $teams->city_id = $request->teacity_ids;
                    }

                    if ($request->hasFile('teamimg')) 
                    {
                        $file = $request->file('teamimg');
                        $folder = $request->folder;
                        $date = date('Y-m-d');
                        $name = $date . rand() . '.' . $file->getClientOriginalExtension();
                        $file->storeAs('attachments/'.$folder.'/'.$slug.'/images', $name,'upload_attachments');
                        // $imagename = $name;
                        $teamimg = 'attachments/'.$folder.'/'.$slug.'/images/'.$name;

                    }
                    else
                    {
                        $teamimg = $teams->teamimg ;
                    
                    }

                    $teams->teamimg = $teamimg;

                    $teams->save();

                    return response()->json(
                        [
                            'status' => true,
                            'username' => 'modhi',
                            'slug' => $slug,
                            'id' => $teams->id,
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
            $teams = Team::findOrFail($id);
            $teams->select = 0;
            $teams->save();

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

    