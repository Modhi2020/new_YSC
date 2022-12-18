<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Models\Slider;
use Carbon\Carbon;
use Toastr;
use App\Traits\AttachFilesTrait;

class SliderController extends Controller
{
    use AttachFilesTrait;

    function __construct()
    {
        
        $this->middleware('permission:show sliders', ['only' => ['index','store']]);
        $this->middleware('permission:add sliders', ['only' => ['create','store']]);
        $this->middleware('permission:edit sliders', ['only' => ['edit','update']]);
        $this->middleware('permission:delete sliders', ['only' => ['destroy']]);
        
    }

    public function index()
    {
        $sliders = Slider::latest()->get();

        return view('admin.sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.sliders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_ar'         => 'required',
            'title_en'         => 'required',
            'description_ar'   => 'required|max:200',
            'description_en'   => 'required|max:200',
            'image' => 'required|mimes:jpeg,jpg,png'
        ]);

        // $image = $request->file('image');
        $slug  = str_slug($request->title_en);

        //    $postimage = Image::make($image)->resize(1600, 980, function ($constraint) {$constraint->aspectRatio();$constraint->upsize();})->save($pathe.$imagename);

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
            $path = 'attachments/sliders';
        }

        $slider = new Slider();
        $slider->title = ['en' => $request->title_en, 'ar' => $request->title_ar];
        $slider->description = ['en' => $request->description_en, 'ar' => $request->description_ar];
        $slider->slug = $slug;
        $slider->image = $imagename;
        $slider->path = $path;
        $slider->save();

        Toastr::success('message', 'Slider created successfully.');
        return redirect()->route('admin.sliders.index');
    }


    public function edit($id)
    {
        $slider = Slider::find($id);

        return view('admin.sliders.edit', compact('slider'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'title_ar'         => 'required',
            'title_en'         => 'required',
            'description_ar'   => 'required|max:200',
            'description_en'   => 'required|max:200',
            'image.*' => 'mimetypes:image/jpeg,image/png,image/jpg',
        ]);

        $image = $request->file('image'); 
        $slider = Slider::find($id);
        $slug  = $slider->slug;

        
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
            $imagename = $slider->image;
            $path = $slider->path;
        }
     
        $slider->title = ['en' => $request->title_en, 'ar' => $request->title_ar];
        $slider->description = ['en' => $request->description_en, 'ar' => $request->description_ar];
        $slider->image = $imagename;
        $slider->path = $path;
        $slider->save();

        Toastr::success('message', 'Slider updated successfully.');
        return redirect()->route('admin.sliders.index');
    }


    public function destroy($id)
    {
        $slider = Slider::find($id);

        if(Storage::disk('upload_attachments')->exists('sliders/'.$slider->slug.'/'.$slider->image)){
            Storage::disk('upload_attachments')->delete('sliders/'.$slider->slug.'/'.$slider->image);
        }

        $slider->delete();

        Toastr::success('message', 'Slider deleted successfully.');
        return back();
    }
}
