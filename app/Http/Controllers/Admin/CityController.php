<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use Toastr;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['Cities'] = City::latest()->where('select',1)->get();

        return view('admin.Cities.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.Cities.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_ar'  => 'required|max:255',
            'name_en'  => 'required|max:255',
        ]);

        try {
            
            City::create(
                    [
                    'name' => ['en' => $request->name_en, 'ar' => $request->name_ar],
                    ]);
                           
            Toastr::success(trans('messages.success'));
            return redirect()->route('admin.cities.index');
        }
        catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['city'] = City::findorFail($id);
        return view('admin.Cities.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            
            City::findorFail($id)->update(
                [
                'name' => ['en' => $request->name_en, 'ar' => $request->name_ar],
                ]);
                       
        Toastr::success(trans('messages.Update'));
        return redirect()->route('admin.cities.index');
        }
        catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Cities = City::findOrFail($id);
        $Cities->select = 0;
        $Cities->save();
        Toastr::success('message', 'Region deleted successfully.');
        return back();
    }
}
