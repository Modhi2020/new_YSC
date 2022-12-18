<?php

namespace App\Repository;

use App\Models\Objective;
use App\Models\City;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Validator;
use File;


class ObjectivesRepository implements ObjectivesRepositoryInterface
{



    public function index()
    {
        $data['Objectives'] = Objective::all();
        $data['Cities'] = City::all();
        return view('admin.aboutus.index', $data);
    }

    public function create()
    {
        $data['Objectives'] = Objective::all();
        $data['Cities'] = City::all();
        return view('admin.aboutus.create', $data);
    }


    public function store($request)
    {  
        
        try {     

                    if(isset($request->ready))
                    {
                        $ready = 1;
                    }
                    else{
                        $ready = 2;
                    }
                    $Objectives = new Objective();
                    $Objectives->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
                    $Objectives->ready = $ready;

                    if(isset($request->city_id))
                    {
                        $Objectives->city_id = $request->city_id;
                    }
                     
                    $Objectives->save();

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
            // return response()->json(
            //             [
            //                 'status' => false,
            //                 'username' => 'modhi',
                           
            //             ]
            //         );
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
    
    public function show($id)
    {

    }

    public function objectivesShow()
    {
        $Objectives = Objective::where('select',1)->latest()->take(6)->get();

        return $Objectives;

    }

    public function edit($id)
    {

        $data['objectives'] = Objective::where('id',$id)->get();
        return  $data ;
    }

    public function update($request)
    {        
        
        try {       
                if ($request->request_type == 1) 
                {
                    if(isset($request->objreadys))
                    {
                        $ready = 1;
                    }
                    else
                    {
                        $ready = 2;
                    }

                    $objectives = Objective::findorFail($request->objective_id);
                    $objectives->name = ['en' => $request->objname_ens, 'ar' => $request->objname_ars];
                    $objectives->ready = $ready;
                  
                    if(isset($request->objcity_ids))
                    {
                        $objectives->city_id = $request->objcity_ids;
                    }

                    $objectives->save();
                    $slug = $objectives->slug;

                    return response()->json(
                        [
                            'status' => true,
                            'username' => 'modhi',
                            'slug' => $slug,
                            'id' => $objectives->id,
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
            $objectives = Objective::findOrFail($id);
            $objectives->select = 0;
            $objectives->save();

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

    