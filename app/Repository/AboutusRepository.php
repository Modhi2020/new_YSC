<?php

namespace App\Repository;

use App\Models\Aboutu;
use App\Models\City;
use App\Models\Team;
use App\Models\Objective;
use App\Models\Occupation;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Validator;
use File;


class AboutusRepository implements AboutusRepositoryInterface
{



    public function index()
    {
        $data['Aboutus'] = Aboutu::all();
        $data['Cities'] = City::all();
        $data['Occupations'] = Occupation::where('select',1)->get();
        return view('admin.aboutus.index', $data);
    }

    public function create()
    {
        $data['Aboutus'] = Aboutu::all();
        $data['Cities'] = City::all();
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

                    $slug  = str_slug($request->title_ar);
                    $Aboutus = new Aboutu();
                    $Aboutus->title = ['en' => $request->title_en, 'ar' => $request->title_ar];
                    $Aboutus->whowe = ['en' => $request->whowe_en, 'ar' => $request->whowe_ar];
                    $Aboutus->whyus = ['en' => $request->whyus_en, 'ar' => $request->whyus_ar];
                    $Aboutus->msg = ['en' => $request->msg_en, 'ar' => $request->msg_ar];
                    $Aboutus->vision = ['en' => $request->vision_en, 'ar' => $request->vision_ar];
                    $Aboutus->teamdesc = ['en' => $request->teamdesc_en, 'ar' => $request->teamdesc_ar];
                    $Aboutus->slug = $slug;
                    $Aboutus->ready = $ready;

                    if(isset($request->city_id))
                    {
                        $Aboutus->city_id = $request->city_id;
                    }
                     
                    if ($request->hasFile('whoweimg')) 
                    {
                        $file = $request->file('whoweimg');
                        $folder = $request->folder;
                        $date = date('Y-m-d');
                        $name = $date . rand() . '.' . $file->getClientOriginalExtension();
                        $file->storeAs('attachments/'.$folder.'/'.$slug.'/images', $name,'upload_attachments');
                        // $imagename = $name;
                        $whoweimg = 'attachments/'.$folder.'/'.$slug.'/images/'.$name;

                    }
                    else
                    {
                        $whoweimg = 'attachments/aboutus/default.png';
                    
                    }

                    $Aboutus->whoweimg = $whoweimg;

                    if ($request->hasFile('whyusimg')) 
                    {
                        $file = $request->file('whyusimg');
                        $folder = $request->folder;
                        $date = date('Y-m-d');
                        $name = $date . rand() . '.' . $file->getClientOriginalExtension();
                        $file->storeAs('attachments/'.$folder.'/'.$slug.'/images', $name,'upload_attachments');
                        // $imagename = $name;
                        $whyusimg = 'attachments/'.$folder.'/'.$slug.'/images/'.$name;

                    }
                    else
                    {
                        $whyusimg = 'attachments/aboutus/default.png';
                    
                    }

                    $Aboutus->whyusimg = $whyusimg;

                    // if ($request->hasFile('visionimg')) 
                    // {
                    //     $file = $request->file('visionimg');
                    //     $folder = $request->folder;
                    //     $date = date('Y-m-d');
                    //     $name = $date . rand() . '.' . $file->getClientOriginalExtension();
                    //     $file->storeAs('attachments/'.$folder.'/'.$slug.'/images', $name,'upload_attachments');
                    //     // $imagename = $name;
                    //     $visionimg = 'attachments/'.$folder.'/'.$slug.'/images/'.$name;

                    // }
                    // else
                    // {
                    //     $visionimg = 'attachments/aboutus/default.png';
                    
                    // }

                    // $Aboutus->visionimg = $visionimg;
                    $Aboutus->save();

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

    public function aboutusShow()
    {
        $Aboutus = Aboutu::where('select',1)->latest()->take(6)->get();

        return $Aboutus;

    }
    
    public function show($id)
    {

    }

    public function edit($id)
    {

        $data['aboutus'] = Aboutu::where('id',$id)->get();
        return  $data ;
    }

    public function update($request)
    {        
        
        try {       
                if ($request->request_type == 1) 
                {

                    if(isset($request->aboreadys))
                    {
                        $ready = 1;
                    }
                    else{
                        $ready = 2;
                    }

                    $aboutus = Aboutu::findorFail($request->aboutus_id);
                    $aboutus->title = ['en' => $request->abotitle_ens, 'ar' => $request->abotitle_ars];
                    $aboutus->whowe = ['en' => $request->abowhowe_ens, 'ar' => $request->abowhowe_ars];
                    $aboutus->whyus = ['en' => $request->abowhyus_ens, 'ar' => $request->abowhyus_ars];
                    $aboutus->msg = ['en' => $request->abomsg_ens, 'ar' => $request->abomsg_ars];
                    $aboutus->vision = ['en' => $request->abovision_ens, 'ar' => $request->abovision_ars];
                    $aboutus->teamdesc = ['en' => $request->aboteamdesc_ens, 'ar' => $request->aboteamdesc_ars];
                    $aboutus->ready = $ready;
                    $slug = $aboutus->slug;
                  
                    if(isset($request->abocity_ids))
                    {
                        $aboutus->city_id = $request->abocity_ids;
                    }

                    if ($request->hasFile('whoweimg')) 
                    {
                        $file = $request->file('whoweimg');
                        $folder = $request->folder;
                        $date = date('Y-m-d');
                        $name = $date . rand() . '.' . $file->getClientOriginalExtension();
                        $file->storeAs('attachments/'.$folder.'/'.$slug.'/images', $name,'upload_attachments');
                        // $imagename = $name;
                        $whoweimg = 'attachments/'.$folder.'/'.$slug.'/images/'.$name;

                    }
                    else
                    {
                        $whoweimg =  $aboutus->whoweimg;
                    
                    }

                    $aboutus->whoweimg = $whoweimg;

                    if ($request->hasFile('whyusimg')) 
                    {
                        $file = $request->file('whyusimg');
                        $folder = $request->folder;
                        $date = date('Y-m-d');
                        $name = $date . rand() . '.' . $file->getClientOriginalExtension();
                        $file->storeAs('attachments/'.$folder.'/'.$slug.'/images', $name,'upload_attachments');
                        // $imagename = $name;
                        $whyusimg = 'attachments/'.$folder.'/'.$slug.'/images/'.$name;

                    }
                    else
                    {
                        $whyusimg = $aboutus->whyusimg;
                    
                    }

                    $aboutus->whyusimg = $whyusimg;

                    $aboutus->save();
                  

                    return response()->json(
                        [
                            'status' => true,
                            'username' => 'modhi',
                            'slug' => $slug,
                            'id' => $aboutus->id,
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
            $aboutus = Aboutu::findOrFail($id);
            $aboutus->select = 0;
            $aboutus->save();

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

    