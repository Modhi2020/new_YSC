<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Models\Testimonial;
use Carbon\Carbon;
use Toastr;
use App\Traits\AttachFilesTrait;

class TestimonialController extends Controller
{
    use AttachFilesTrait;
    public function index()
    {
        $testimonials = Testimonial::latest()->get();

        return view('pages.testimonials', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonials.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_ar'         => 'required',
            'name_en'         => 'required',
            'testimonial_ar'   => 'required|max:250',
            'testimonial_en'   => 'required|max:250',
            'image' => 'required|mimes:jpeg,jpg,png',
        ]);

      
        // $image = $request->file('image');
        $slug  = str_slug($request->name_en);


        if ($request->hasFile('image')) 
        {
            $file = $request->file('image');
            $folder = $request->folder;
            $date = date('Y-m-d');
            $name = $date . rand() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('attachments/'.$folder.'/'.$slug.'/images', $name,'upload_attachments');
            $imagename = $name;
            $path = 'attachments/'.$folder.'/'.$slug.'/images';

        }
        else
        {
            $imagename = 'default.png';
            $path = 'attachments/testimonials';
        }

        $testimonial = new Testimonial();
        $testimonial->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
        $testimonial->testimonial = ['en' => $request->testimonial_en, 'ar' => $request->testimonial_ar];
        $testimonial->slug = $slug;
        $testimonial->image = $imagename;
        $testimonial->path = $path;
        $testimonial->save();

        Toastr::success('message', 'Testimonial created successfully.');
        return redirect()->back() ;
    }


    public function edit($id)
    {
        $testimonial = Testimonial::find($id);

        return view('admin.testimonials.edit', compact('testimonial'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name_ar'         => 'required',
            'name_en'         => 'required',
            'testimonial_ar'   => 'required|max:250',
            'testimonial_en'   => 'required|max:250',
            'image' => 'mimes:jpeg,jpg,png',
        ]);

        $image = $request->file('image'); 
        // $slug  = str_slug($request->name_en);
        $testimonial = Testimonial::find($id);

        $slug  = str_slug($testimonial->slug);
       

        if ($request->hasFile('image')) 
        {
            $file = $request->file('image');
            $folder = $request->folder;
            $date = date('Y-m-d');
            $name = $date . rand() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('attachments/'.$folder.'/'.$slug.'/images', $name,'upload_attachments');
            $imagename = $name;
            $path = 'attachments/'.$folder.'/'.$slug.'/images';

        }
        else
        {
            $imagename = $testimonial->image;
            $path = 'attachments/testimonials';
        }


        $testimonial->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
        $testimonial->testimonial = ['en' => $request->testimonial_en, 'ar' => $request->testimonial_ar];
        $testimonial->image = $imagename;
        $testimonial->path = $path;
        $testimonial->save();

        Toastr::success('message', 'Testimonial updated successfully.');
        return redirect()->route('admin.testimonials.index');
    }


    public function destroy($id)
    {
        $testimonial = Testimonial::find($id);

        if(Storage::disk('upload_attachments')->exists('testimonials'.'/'.$testimonial->name.'/'.$testimonial->image))
        {
            Storage::disk('upload_attachments')->delete('testimonials'.'/'.$testimonial->name.'/'.$testimonial->image);
        }

        $testimonial->delete();

        Toastr::success('message', 'Testimonial deleted successfully.');
        return back();
    }
}
