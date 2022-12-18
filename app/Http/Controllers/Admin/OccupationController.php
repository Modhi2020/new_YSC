<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Models\Occupation;
use App\Models\Directorate;
use Carbon\Carbon;
use Toastr;
use App\Traits\AttachFilesTrait;

class OccupationController extends Controller
{
    use AttachFilesTrait;
    public function index()
    {
        $occupations = Occupation::latest()->get();

        return view('admin.occupations.index', compact('occupations'));
    }

    public function create()
    {
        $data['Directorates'] = Directorate::get();
        return view('admin.occupations.create',$data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_ar'         => 'required',
            'name_en'         => 'required',
        ]);

        $occupations = new Occupation();
        $occupations->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
        $occupations->save();

        Toastr::success('message', 'Occupation created successfully.');
        return redirect()->route('admin.occupations.index');
    }


    public function edit($id)
    {
        $data['occupation'] = Occupation::findOrFail($id);

        return view('admin.occupations.edit', $data);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name_ar'         => 'required',
            'name_en'         => 'required',
        ]);

 
        $occupations = Occupation::findOrFail($id);
        $occupations->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
        $occupations->save();

        Toastr::success('message', 'Occupation updated successfully.');
        return redirect()->route('admin.occupations.index');
    }


    public function destroy($id)
    {
        $occupations = Occupation::findOrFail($id);
        $occupations->select = 0;
        $occupations->save();
        Toastr::success('message', 'Region deleted successfully.');
        return back();
    }
}
