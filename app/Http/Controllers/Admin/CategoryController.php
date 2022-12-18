<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Models\Category;
use Carbon\Carbon;
use Toastr;
use App\Traits\AttachFilesTrait;

class CategoryController extends Controller
{

    use AttachFilesTrait;
    
    public function index()
    {
        $categories = Category::latest()->get();

        return view('admin.categories.index', compact('categories'));
    }


    public function create()
    {
        return view('admin.categories.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name_ar'  => 'required|max:255',
            'name_en'  => 'required|max:255',
            'image' => 'required|mimes:jpeg,jpg,png'
        ]);

        $image = $request->file('image');
        $slug  = str_slug($request->name_en);

        if($request->hasFile('image')) 
        {
            $logo_name = $request->file('image')->getClientOriginalName();
            
            // Slider::where('id', $request->id)->update(['image' => $logo_name]);
            $this->uploadFile($request,'image','categories'.'/'.$slug);
            $imagename = $logo_name;
        }

        else
        {
            $imagename = 'default.png';
        }

        $category = new Category();
        $category->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
        $category->slug = $slug;
        $category->image = $imagename;
        $category->save();

        Toastr::success('message', 'Category created successfully.');
        return redirect()->route('admin.categories.index');
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $category = Category::find($id);

        return view('admin.categories.edit', compact('category'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name_ar'  => 'required|max:255',
            'name_en'  => 'required|max:255',
            'image' => 'mimes:jpeg,jpg,png'
        ]);

        $image = $request->file('image');
        // $slug  = str_slug($request->name_en);
        $category = Category::find($id);

        $slug  = $category->slug;

        if(isset($image)){
            $logo_name = $request->file('image')->getClientOriginalName();
            
            // Slider::where('id', $request->id)->update(['image' => $logo_name]);
            $this->uploadFile($request,'image','categories'.'/'.$slug);
            $imagename = $logo_name;
        }else{
            $imagename = $category->image;
        }

        $category->name =  ['en' => $request->name_en, 'ar' => $request->name_ar];
        // $category->slug = $slug;
        $category->image = $imagename;
        $category->save();

        Toastr::success('message', 'Category updated successfully.');
        return redirect()->route('admin.categories.index');
    }


    public function destroy($id)
    {
        $category = Category::find($id);

        if(Storage::disk('public')->exists('category/slider/'.$category->image)){
            Storage::disk('public')->delete('category/slider/'.$category->image);
        }

        if(Storage::disk('public')->exists('category/thumb/'.$category->image)){
            Storage::disk('public')->delete('category/thumb/'.$category->image);
        }

        $category->delete();
        $category->posts()->detach();

        Toastr::success('message', 'Category deleted successfully.');
        return back();
    }
}
