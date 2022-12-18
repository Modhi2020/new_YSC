<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
 
use App\Models\TaskFile;
 
class MultiFileUploadAjaxController extends Controller
{
    public function index()
    {
        return view('multi-file-ajax-upload');
    }
 
 
    public function storeMultiFile(Request $request)
    {
        // return response()->json(['success'=>'Ajax Multiple fIle has been uploaded']);
       $validatedData = $request->validate([
        'files' => 'required',
        'files.*' => 'mimes:csv,txt,xlx,xls,pdf,jpeg,png,jpg,gif'
        ]);
 
        if($request->TotalFiles > 0)
        {
                
           for ($x = 0; $x < $request->TotalFiles; $x++) 
           {
 
               if ($request->hasFile('files'.$x)) 
                {
                    $file      = $request->file('files'.$x);
 
                    $path = $file->store('public/files');
                    $name = $file->getClientOriginalName();
 
                    $insert[$x]['filename'] = $name;
                    $insert[$x]['imageable_id'] = 1;
                    $insert[$x]['imageable_type'] = $name;
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
}