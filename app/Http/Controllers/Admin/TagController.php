<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Toastr;

class TagController extends Controller
{

    public function index()
    {
        $tags = Tag::latest()->get();

        return view('admin.tags.index', compact('tags'));
    }


    public function create()
    {
        return view('admin.tags.create');
    }


    public function store(Request $request)
    {

       
        // $var1 = $request->name_en;
        // $var2 = str_replace("600", "400", $var1);
        // $var2 = str_replace("450", "350", $var1);
        // return $var2;
        // echo $var2; 

        $request->validate([
            'name_ar'  => 'required|max:255',
            'name_en'  => 'required|max:255',
        ]);

        $tag = new Tag();
        $tag->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
        $tag->slug = str_slug($request->name_en);
        $tag->save();

        Toastr::success('message', 'Tag created successfully.');
        return redirect()->route('admin.tags.index');
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $tag = Tag::find($id);

        return view('admin.tags.edit',compact('tag'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name_ar'  => 'required|max:255',
            'name_en'  => 'required|max:255',
        ]);

        $tag = Tag::find($id);
        $tag->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
        // $tag->slug = str_slug($request->name);
        $tag->save();

        Toastr::success('message', 'Tag updated successfully.');
        return redirect()->route('admin.tags.index');
    }


    public function destroy($id)
    {
        $tag = Tag::find($id);
        $tag->delete();
        $tag->posts()->detach();

        Toastr::success('message', 'Tag deleted successfully.');
        return back();
    }
}
