<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use App\Models\TaskFile;

trait UploadMultiImagesTrait
{
    public function UploadMultiImagesTrait($request)
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
                 $insert[$x]['imageable_type'] = 'App\Models\News';
                 $insert[$x]['page'] = $page;
                 $insert[$x]['type'] = 1;
                 $insert[$x]['path'] = 'attachments/'.$folder.'/'.$request->slug.'/images';
             }
             
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
