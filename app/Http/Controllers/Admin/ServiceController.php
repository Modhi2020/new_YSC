<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\ServiceRepositoryInterface;
use Validator;

class ServiceController extends Controller
{
    protected $Service;

    public function __construct(ServiceRepositoryInterface $Service)
    {
        $this->Service =$Service;
        // $this->middleware('permission:show services', ['only' => ['index','servicesShow']]);
        // $this->middleware('permission:add services', ['only' => ['create','serviceStore']]);
        // $this->middleware('permission:edit services', ['only' => ['edit','servicesUpdate']]);
        // $this->middleware('permission:delete services', ['only' => ['servicesdestroy']]);

        // $this->middleware('permission:show programs', ['only' => ['index','programsShow']]);
        // $this->middleware('permission:add programs', ['only' => ['create','programsStore']]);
        // $this->middleware('permission:edit programs', ['only' => ['edit','programsUpdate']]);
        // $this->middleware('permission:delete programs', ['only' => ['programsDestroy']]);

        // $this->middleware('permission:show mysessions', ['only' => ['index','mysessionsShow']]);
        // $this->middleware('permission:add mysessions', ['only' => ['create','mysessionsStore']]);
        // $this->middleware('permission:edit mysessions', ['only' => ['edit','mysessionsUpdate']]);
        // $this->middleware('permission:delete mysessions', ['only' => ['mysessionsDestroy']]);
    }

    public function index()
    {
        return $this->Service->index();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->Service->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->Service->edit($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        return $this->Service->update($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->Service->destroy($id);
    }


    public function serviceStore(Request $request)
    {
        return $this->Service->serviceStore($request);
    }

    public function servicesShow()
    {
        return $this->Service->servicesShow();
    }

    public function getServiceById($id)
    {
        return $this->Service->getServiceById($id);
    }

    public function updateServices(Request $request)
    {
        return $this->Service->updateServices($request);
    }

    public function destroyServices($id)
    {
        return $this->Service->destroyServices($id);
    }

    public function programsStore(Request $request)
    {
          
        return $this->Service->programsStore($request);
    }

    public function programsShow()
    {
        return $this->Service->programsShow();
    }

    public function getProgramsById($id)
    {
        return $this->Service->getProgramsById($id);
    }

    public function updatePrograms(Request $request)
    {
        return $this->Service->updatePrograms($request);
    }

    public function destroyPrograms($id)
    {
        return $this->Service->destroyPrograms($id);
    }

    public function mysessionsStore(Request $request)
    {
          
        return $this->Service->mysessionsStore($request);
    }

    public function mysessionsShow()
    {
        return $this->Service->mysessionsShow();
    }

    

    public function upload_image(Request $request)
    {
        return $this->Service->upload_image($request);
    }

    public function upload_images(Request $request)  
    {
        return $this->Service->upload_images($request);
    }

    public function upload_articals_images(Request $request)  
    {
        return $this->Service->upload_articals_images($request);
    }

    public function upload_files(Request $request)
    {
        return $this->Service->upload_files($request);
    }

    

}
