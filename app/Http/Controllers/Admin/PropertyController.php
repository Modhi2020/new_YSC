<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Feature;
use App\Models\PropertyImageGallery;
use App\Models\Comment;
use App\Models\PropertyPurpose;
use App\Models\PropertyType;
use App\Models\Image;

use Illuminate\Support\Facades\Storage;
// use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use Toastr;
use Auth;
use File;
use App\Traits\AttachFilesTrait;

class PropertyController extends Controller
{

    use AttachFilesTrait;
    
    public function index()
    {
        $properties = Property::latest()->withCount('comments')->get();

        return view('admin.properties.index',compact('properties'));
    }


    public function create()
    {   
        $data['features'] = Feature::all();
        $data['PropertyPurposes'] = PropertyPurpose::all();
        $data['PropertyTypes'] = PropertyType::all();
        return view('admin.properties.create',$data);
    }


    public function store(Request $request)
    {
        $request->validate([
            'price'     => 'required',
            'purpose'   => 'required',
            'type'      => 'required',
            'bedroom'   => 'required',
            'bathroom'  => 'required',
            'city'      => 'required',
            'address'   => 'required',
            'area'      => 'required',
            //'image'     => 'required|image|mimes:jpeg,jpg,png',
            //'floor_plan'=> 'image|mimes:jpeg,jpg,png',
            'description'        => 'required',
            'location_latitude'  => 'required',
            'location_longitude' => 'required',
        ]);

        $image = $request->file('image');
        $slug  = str_slug($request->title_en);

        if($request->hasFile('floor_plan')) 
        {
            $logo_name = $request->file('floor_plan')->getClientOriginalName();
            
            // Slider::where('id', $request->id)->update(['image' => $logo_name]);
            $this->uploadFile($request,'floor_plan','property'.'/'.$slug);
            $imagefloorplan = $logo_name;
        }

        else
        {
            $imagefloorplan = 'default.png';
        }


        $floor_plan = $request->file('floor_plan');
      

        $property = new Property();
        $property->title    = ['en' => $request->title_en, 'ar' => $request->title_ar];
        $property->slug     = $slug;
        $property->price    = $request->price;
        $property->purpose  = $request->purpose;
        $property->type     = $request->type;
        // $property->image    = $imagename;
        $property->bedroom  = $request->bedroom;
        $property->bathroom = $request->bathroom;
        $property->city     = $request->city;
        $property->city_slug= str_slug($request->city);
        $property->address  = $request->address;
        $property->area     = $request->area;


        if(isset($request->featured)){
            $property->featured = true;
        }
        $property->agent_id = Auth::id();
        $property->description          = $request->description;
        $property->video                = $request->video;
        $property->floor_plan           = $imagefloorplan;
        $property->location_latitude    = $request->location_latitude;
        $property->location_longitude   = $request->location_longitude;
        $property->nearby               = $request->nearby;
        $property->save();

        $property->features()->attach($request->features);


        $gallary = $request->file('gallaryimage');

        if($gallary)
        {
            foreach($gallary as $images)
            {
                $currentDate = Carbon::now()->toDateString();
                $galimage['name'] = 'gallary-'.$currentDate.'-'.uniqid().'.'.$images->getClientOriginalExtension();
                $galimage['size'] = 12;//$images->getClientSize();
                $galimage['property_id'] = $property->id;
                
                if(!Storage::disk('public')->exists('property/gallery')){
                    Storage::disk('public')->makeDirectory('property/gallery');
                }
                $propertyimage = Image::make($images)->stream();
                Storage::disk('public')->put('property/gallery/'.$galimage['name'], $propertyimage);

                $property->gallery()->create($galimage);
            }
        }

         // insert img
         if($request->hasfile('photos'))
         {
             foreach($request->file('photos') as $file)
             {
                 $name = $file->getClientOriginalName();
                 $file->storeAs('attachments/property/'.$property->slug, $file->getClientOriginalName(),'upload_attachments');
 
                 // insert in image_table
                 $images= new Image();
                 $images->filename=$name;
                 $images->imageable_id= $property->id;
                 $images->imageable_type = 'App\Models\Property';
                 $images->save();
             }
         }
 

        Toastr::success('message', 'Property created successfully.');
        return redirect()->route('admin.properties.index');
    }


    public function show(Property $property)
    {
        $property = Property::withCount('comments')->find($property->id);

        $videoembed = $this->convertYoutube($property->video, 560, 315);

        return view('admin.properties.show',compact('property','videoembed'));
    }


    public function edit(Property $property)
    {
        // dd($property);
        $data['features'] = Feature::all();
        $data['property'] = Property::find($property->id);
        $data['PropertyPurposes'] = PropertyPurpose::all();
        $data['PropertyTypes'] = PropertyType::all();
        $data['videoembed'] = $this->convertYoutube($property->video);

        return view('admin.properties.edit',$data);
    }


    public function update(Request $request, $property)
    {
        $request->validate([
            'price'     => 'required',
            'purpose'   => 'required',
            'type'      => 'required',
            'bedroom'   => 'required',
            'bathroom'  => 'required',
            'city'      => 'required',
            'address'   => 'required',
            'area'      => 'required',
           // 'image'     => 'image|mimes:jpeg,jpg,png',
            //'floor_plan'=> 'image|mimes:jpeg,jpg,png',
            'description'        => 'required',
            'location_latitude'  => 'required',
            'location_longitude' => 'required'
        ]);

        // return 
        $image = $request->file('image');
        // $slug  =str_slug($request->title_en);

        $property = Property::find($request->id);
        $slug  = $property->slug;

        if(isset($image)){
            $currentDate = Carbon::now()->toDateString();
            $imagename = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();

            if(!Storage::disk('public')->exists('property')){
                Storage::disk('public')->makeDirectory('property');
            }
            if(Storage::disk('public')->exists('property/'.$property->image)){
                Storage::disk('public')->delete('property/'.$property->image);
            }
            $propertyimage = Image::make($image)->stream();
            Storage::disk('public')->put('property/'.$imagename, $propertyimage);

        }else{
            $imagename = $property->image;
        }


        $floor_plan = $request->file('floor_plan');


        if($request->hasFile('floor_plan')) 
        {
            $logo_name = $request->file('floor_plan')->getClientOriginalName();
            
            // Slider::where('id', $request->id)->update(['image' => $logo_name]);
            $this->uploadFile($request,'floor_plan','property'.'/'.$slug);
            $imagefloorplan = $logo_name;
        }

       else{
            $imagefloorplan = $property->floor_plan;
        }

        $property->title        =  ['en' => $request->title_en, 'ar' => $request->title_ar];
        $property->slug         = $slug;
        $property->price        = $request->price;
        $property->purpose      = $request->purpose;
        $property->type         = $request->type;
        // $property->image        = $imagename;
        $property->bedroom      = $request->bedroom;
        $property->bathroom     = $request->bathroom;
        $property->city         = $request->city;
        $property->city_slug    = str_slug($request->city);
        $property->address      = $request->address;
        $property->area         = $request->area;
        $property->floor_plan      = $imagefloorplan;

        if(isset($request->featured)){
            $property->featured = true;
        }else{
            $property->featured = false;
        }

        $property->description  = $request->description;
        $property->video        = $request->video;
        $property->floor_plan   = $imagefloorplan;
        $property->location_latitude  = $request->location_latitude;
        $property->location_longitude = $request->location_longitude;
        $property->nearby             = $request->nearby;
        $property->save();

        $property->features()->sync($request->features);

        // $gallary = $request->file('gallaryimage');
        // if($gallary){
        //     foreach($gallary as $images){
        //         if(isset($images))
        //         {
        //             $currentDate = Carbon::now()->toDateString();
        //             $galimage['name'] = 'gallary-'.$currentDate.'-'.uniqid().'.'.$images->getClientOriginalExtension();
        //             $galimage['size'] = $images->getClientSize();
        //             $galimage['property_id'] = $property->id;
                    
        //             if(!Storage::disk('public')->exists('property/gallery')){
        //                 Storage::disk('public')->makeDirectory('property/gallery');
        //             }
        //             $propertyimage = Image::make($images)->stream();
        //             Storage::disk('public')->put('property/gallery/'.$galimage['name'], $propertyimage);

        //             $property->gallery()->create($galimage);
        //         }
        //     }
        // }
            // insert img
            if($request->hasfile('gallaryimage'))
            {
                foreach($request->file('gallaryimage') as $file)
                {
                    $name = $file->getClientOriginalName();
                    $file->storeAs('attachments/property/'.$property->slug, $file->getClientOriginalName(),'upload_attachments');
    
                    // insert in image_table
                    Image::updateOrCreate([
                        'filename'=>$name,
                        'imageable_id'=>$property->id,
                        'imageable_type'=>'App\Models\Property',
                    ]);
                }
            }
        

        Toastr::success('message', 'Property updated successfully.');
        return redirect()->route('admin.properties.index');
    }

 
    public function destroy(Property $property)
    {
        $property = Property::find($property->id);

        if(Storage::disk('public')->exists('property/'.$property->image)){
            Storage::disk('public')->delete('property/'.$property->image);
        }
        if(Storage::disk('public')->exists('property/'.$property->floor_plan)){
            Storage::disk('public')->delete('property/'.$property->floor_plan);
        }

        $property->delete();
        
        $galleries = $property->gallery;
        if($galleries)
        {
            foreach ($galleries as $key => $gallery) {
                if(Storage::disk('public')->exists('property/gallery/'.$gallery->name)){
                    Storage::disk('public')->delete('property/gallery/'.$gallery->name);
                }
                PropertyImageGallery::destroy($gallery->id);
            }
        }

        $property->features()->detach();
        $property->comments()->delete();

        Toastr::success('message', 'Property deleted successfully.');
        return back();
    }


    public function galleryImageDelete(Request $request){
        
        $gallaryimg = PropertyImageGallery::find($request->id)->delete();

        if(Storage::disk('public')->exists('property/gallery/'.$request->image)){
            Storage::disk('public')->delete('property/gallery/'.$request->image);
        }

        if($request->ajax()){

            return response()->json(['msg' => $gallaryimg]);
        }
    }

    // YOUTUBE LINK TO EMBED CODE
    private function convertYoutube($youtubelink, $w = 250, $h = 140) {
        return preg_replace(
            "/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
            "<iframe width=\"$w\" height=\"$h\" src=\"//www.youtube.com/embed/$2\" frameborder=\"0\" allowfullscreen></iframe>",
            $youtubelink
        );
    }
}
