<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use App\Models\TaskFile;

trait UploadImageTrait
{
    public function UploadImageTrait($request)
    {
            if ($request->hasFile('images')) 
             {
                 $file = $request->file('image');
                 $slug = $request->slug;
                 $folder = $request->folder;
                 $date = date('Y-m-d');
                 $name = $date . rand() . '.' . $file->getClientOriginalExtension();
                 $file->storeAs('attachments/'.$folder.'/'.$request->slug.'/images', $name,'upload_attachments');

                 $insert[$x]['filename'] = $name;
                 $insert[$x]['imageable_id'] = $id;
                 $insert[$x]['page'] = $page;
                 $insert[$x]['type'] = 1;
                 $insert[$x]['path'] = 'attachments/'.$folder.'/'.$request->slug.'/images';
             }
             
        $model = $request->model;
        $model::insert($insert);

    }

    public function deleteFile($name)
    {
        $exists = Storage::disk('upload_attachments')->exists('attachments/'.$folder.'/'.$name);

        if($exists)
        {
            Storage::disk('upload_attachments')->delete('attachments/'.$folder.'/'.$name);
        }
    }
}

$validation = Validator::make($request->all(), [
    'select_file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
   ]);
   if($validation->passes())
   {
    
    $image = $request->file('image');
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