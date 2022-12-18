<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Models\Department;
use App\Models\DepartmentType;
use Carbon\Carbon;
use Toastr;
use App\Traits\AttachFilesTrait;

class DepartmentController extends Controller
{
    use AttachFilesTrait;
    public function index()
    {
        $Departments = Department::latest()->get();

        return view('admin.departments.index', compact('Departments'));
    }

    public function create()
    {
        $data['DepartmentTypes'] = DepartmentType::get();
        $data['Departments'] = Department::where('type',1)->where('select',1)->get();
        return view('admin.departments.create',$data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_ar'         => 'required',
            'name_en'         => 'required',
            'type'            => 'required',
        ]);

        // $image = $request->file('image');
        $slug  = str_slug($request->name_ar);
        // $path_pub=public_path();

        $Departments = new Department();
        $Departments->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
        $Departments->slug = $slug;
        $Departments->type =  $request->type;

        if(isset($request->type) && ($request->type == 2))
        {
            $Departments->dep_id =  $request->dep_no;
        }

        if(isset($request->ready))
        {
            $ready = 1;
        }
        else{
            $ready = 2;
        }

        $Departments->ready = $ready;
        $Departments->save();

        Toastr::success('message', 'Department created successfully.');
        return redirect()->route('admin.departments.index');
    }


    public function edit($id)
    {
        $data['Department'] = Department::findOrFail($id);
        $data['DepartmentTypes'] = DepartmentType::get();

        return view('admin.departments.edit', $data);
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
 
        $Departments = Department::findOrFail($id);
        $Departments->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
        $Departments->directorate_id =  $request->directorate_id;
        $Departments->mylocation = $mylocation;
        $Departments->save();

        Toastr::success('message', 'Department updated successfully.');
        return redirect()->route('admin.departments.index');
    }


    public function destroy($id)
    {
        $Departments = Department::findOrFail($id);
        $Departments->select = 0;
        $Departments->save();
        Toastr::success('message', 'Department deleted successfully.');
        return back();
    }

    public function get_departments($id)
    {
        $Departments = Department::where('dep_id',$id)->pluck('name','id');
        return $Departments;

    }
}
