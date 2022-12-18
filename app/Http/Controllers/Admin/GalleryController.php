<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Models\Gallery;
use App\Models\Album;
use Carbon\Carbon;
use Toastr;
use File;
use App\Traits\AttachFilesTrait;

class GalleryController extends Controller
{
    use AttachFilesTrait;

    public function album()
    {
        $albums = Album::latest()->with('galleryimages')->get(); //return $albums;

        return view('admin.galleries.album', compact('albums'));
    }


    public function albumStore(Request $request)
    {
        Album::create([
            'name' => $request->name,
            'user_id' => \Auth::id()
        ]);
        return back();
    }


    public function albumGallery($id)
    {
        $album_id = $id;

        $galleries = Gallery::latest()->where('album_id',$album_id)->get();

        return view('admin.galleries.gallerytemp',compact('galleries','album_id'));
    }


    public function Gallerystore(Request $request)
    {

        // dd($request);

        $albumid = $request->input('albumid');

        // $image = $request->file('file');

            // $currentDate = Carbon::now()->toDateString();
            // $imagename = 'gallery-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            // $name = $image->getClientOriginalName();
            // $imagesize = $image->getClientSize();
            // $imagesize=$image->file('image')->getSize();
       

            // $logo_name = $request->file('file')->getClientOriginalName();
            // $imagename = $logo_name;
            // $path_pub=public_path();
            // $patt='\attachments\gallery';
            // $pathed=$path_pub.$patt.$name;  
            //   $imagelink = Storage::url($imagename);
          

            // Image::make($image)->resize(1800, 480, function ($constraint) {$constraint->aspectRatio();$constraint->upsize();})->save($pathed);

            // dd($request);
            // return $request->file('files') ;
             // insert img
         if($request->hasfile('files'))
         {
             foreach($request->file('files') as $file)
             { 
                 $name = $file->getClientOriginalName();

                 $patt='\attachments\gallery';
                 $pbmb =  $path_pub.$patt;
                // Image::make($file)->resize(1800, 480, function ($constraint) {$constraint->aspectRatio();$constraint->upsize();})->save($pbmb.$file->getClientOriginalName());
                
                $file->storeAs('attachments/gallery/'.$albumid, $file->getClientOriginalName(),'upload_attachments');
                 $imagetype = $file->getClientMimeType();
                //  $imagesize = "300";
                $imagesize = $file->getSize();
                    // getClientSize();
                 $imagelink ='/attachments/gallery';

                 // insert in image_table
                 Gallery::create([
                    'album_id'  => $albumid,
                    'image'     => $name,
                    'size'      => $imagesize,
                    'type'      => $imagetype,
                    'link'      => $imagelink
                ]);

             }
         }
 

            // if(!Storage::disk('public')->exists('gallery')){
            //     Storage::disk('public')->makeDirectory('gallery');
            // }
            // $imagegallery = Image::make($image)->stream();
            // Storage::disk('public')->put('gallery/'.$imagename, $imagegallery);

          

           


        Toastr::success('message', 'Images uploaded successfully.');

        return back();
    }

}
