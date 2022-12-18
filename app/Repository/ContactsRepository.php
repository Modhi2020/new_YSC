<?php

namespace App\Repository;

use App\Models\Contact;
use App\Models\City;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Validator;
use File;
use Toastr;


class ContactsRepository implements ContactsRepositoryInterface
{



    public function index()
    {
        $data['Contacts'] = Contact::latest()->where('select',1)->get();
        $data['Cities'] = City::all();
        return view('admin.contacts.index', $data);
    }

    public function create()
    {
        // $data['Aboutus'] = Contact::all();
        $data['Cities'] = City::all();
        return view('admin.contacts.create', $data);
    }


    public function store($request)
    {  
        
        try { 
            
            // <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7757.013756696557!2d44.025328440624534!3d13.565814462787076!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x34ccdded15691037!2z2YXYsdmD2LIg2K7Yr9mF2KfYqiDYp9mE2LTYqNin2Kg!5e0!3m2!1szh-CN!2sus!4v1659741868529!5m2!1szh-CN!2sus" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            
           
                $mylocation_old = $request->mylocation;
                // $mylocation = str_replace("600", "400", $mylocation_old);
                // $mylocation = str_replace("450", "350", $mylocation);
                $mylocation = str_replace('<iframe src=', " ", $mylocation_old);
                $mylocation = str_replace('width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>', " ", $mylocation);
                $mylocation = str_replace('"', " ", $mylocation);
     
                $contacts = new Contact();
                $contacts->address = ['en' => $request->address_en, 'ar' => $request->address_ar];
                $contacts->phone1 =  $request->phone1;
                $contacts->phone2 = $request->phone2;
                $contacts->email = $request->email;
                $contacts->facebook = $request->facebook;
                $contacts->twitter = $request->twitter;
                $contacts->linkedin = $request->linkedin;
                $contacts->instagram = $request->instagram;
                $contacts->telegram = $request->telegram;
                $contacts->mylocation = $mylocation;

                if(isset($request->city_id))
                {
                    $contacts->city_id = $request->city_id;
                }
                    
                $contacts->save();

                Toastr::success('{{ trans("libraries_trans.save_detail") }}','{{ trans("libraries_trans.save_title") }}');
                return redirect()->route('admin.contacts.index');
                  

          
        }
        catch (\Exception $e) {
          
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function aboutusShow()
    {
        $Aboutus = Contact::where('select',1)->latest()->take(6)->get();

        return $Aboutus;

    }
    
    public function show($id)
    {

    }

    public function edit($id)
    {

        $data['Cities'] = City::all();
        $data['Contacts'] = Contact::find($id);
        return view('admin.contacts.edit', $data);
    }

    public function update($request)
    {        
        
        try { 

          
            $mylocation_old = $request->mylocation;
            // $mylocation = str_replace("600", "400", $mylocation_old);
            // $mylocation = str_replace("450", "350", $mylocation);
            $mylocation = str_replace('<iframe src=', " ", $mylocation_old);
            $mylocation = str_replace('width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>', " ", $mylocation);
            $mylocation = str_replace('"', " ", $mylocation);
 
            $contacts = Contact::findOrFail($request->id);
            $contacts->address = ['en' => $request->address_en, 'ar' => $request->address_ar];
            $contacts->phone1 =  $request->phone1;
            $contacts->phone2 = $request->phone2;
            $contacts->email = $request->email;
            $contacts->facebook = $request->facebook;
            $contacts->twitter = $request->twitter;
            $contacts->linkedin = $request->linkedin;
            $contacts->instagram = $request->instagram;
            $contacts->telegram = $request->telegram;
            $contacts->mylocation = $mylocation;

            if(isset($request->city_id))
            {
                $contacts->city_id = $request->city_id;
            }
                
            $contacts->save();   
            Toastr::success('{{ trans("libraries_trans.save_detail") }}','{{ trans("libraries_trans.save_title") }}');
            return redirect()->route('admin.contacts.index');
              
                    
           
        }
        catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $Contacts = Contact::findOrFail($id);
            $Contacts->select = 0;
            $Contacts->save();

            Toastr::error('{{ trans("libraries_trans.save_detail") }}','{{ trans("libraries_trans.save_title") }}');
            return redirect()->route('admin.contacts.index');

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

    