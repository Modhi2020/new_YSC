<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Models\Region;
use App\Models\Directorate;
use Carbon\Carbon;
use Toastr;
use App\Traits\AttachFilesTrait;

class RegionController extends Controller
{
    use AttachFilesTrait;
    public function index()
    {
        $Regions = Region::latest()->get();

        return view('admin.regions.index', compact('Regions'));
    }

    public function create()
    {
        $data['Directorates'] = Directorate::get();
        return view('admin.regions.create',$data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_ar'         => 'required',
            'name_en'         => 'required',
            'directorate_id'   => 'required',
        ]);

        // $image = $request->file('image');
        $slug  = str_slug($request->name_en);
        // $path_pub=public_path();

        $mylocation_old = $request->mylocation;
        // $mylocation = str_replace("600", "400", $mylocation_old);
        // $mylocation = str_replace("450", "350", $mylocation);
        $mylocation = str_replace('<iframe src=', " ", $mylocation_old);
        $mylocation = str_replace('width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>', " ", $mylocation);
        $mylocation = str_replace('"', " ", $mylocation);

        $Regions = new Region();
        $Regions->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
        $Regions->directorate_id =  $request->directorate_id;
        $Regions->mylocation = $mylocation;
        $Regions->slug = $slug;
        $Regions->save();

        Toastr::success('message', 'Region created successfully.');
        return redirect()->route('admin.regions.index');
    }


    public function edit($id)
    {
        $data['region'] = Region::findOrFail($id);
        $data['Directorates'] = Directorate::get();

        return view('admin.regions.edit', $data);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name_ar'         => 'required',
            'name_en'         => 'required',
            'directorate_id'   => 'required',
        ]);

        $mylocation_old = $request->mylocation;
        // $mylocation = str_replace("600", "400", $mylocation_old);
        // $mylocation = str_replace("450", "350", $mylocation);
        $mylocation = str_replace('<iframe src=', " ", $mylocation_old);
        $mylocation = str_replace('width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>', " ", $mylocation);
        $mylocation = str_replace('"', " ", $mylocation);
 
        $Regions = Region::findOrFail($id);
        $Regions->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
        $Regions->directorate_id =  $request->directorate_id;
        $Regions->mylocation = $mylocation;
        $Regions->save();

        Toastr::success('message', 'Region updated successfully.');
        return redirect()->route('admin.regions.index');
    }


    public function destroy($id)
    {
        $Regions = Region::findOrFail($id);
        $Regions->select = 0;
        $Regions->save();
        Toastr::success('message', 'Region deleted successfully.');
        return back();
    }
}
