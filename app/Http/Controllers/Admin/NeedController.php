<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\NeedRepositoryInterface;
use Validator;

class NeedController extends Controller
{
    protected $Need;

    public function __construct(NeedRepositoryInterface $Need)
    {
        $this->Need =$Need;
    }

    public function index()
    {
        return $this->Need->index();
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
        return $this->Need->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->Need->edit($id);
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
        return $this->Need->update($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->Need->destroy($id);
    }


    public function opportunitiesStore(Request $request)
    {
        return $this->Need->opportunitiesStore($request);
    }

    public function opportunitiesShow()
    {
        return $this->Need->opportunitiesShow();
    }

    public function mosquesStore(Request $request)
    {
          
        return $this->Need->mosquesStore($request);
    }

    public function mosquesShow()
    {
        return $this->Need->mosquesShow();
    }

    public function preachersStore(Request $request)
    {
          
        return $this->Need->preachersStore($request);
    }

    public function preachersShow()
    {
        return $this->Need->preachersShow();
    }

    public function AssginmosquesToNeed(Request $request)
    {          
        return $this->Need->AssginmosquesToNeed($request);
    }

    

    public function upload_image(Request $request)
    {
        return $this->Need->upload_image($request);
    }

    public function upload_images(Request $request)  
    {
        return $this->Need->upload_images($request);
    }

    public function upload_articals_images(Request $request)  
    {
        return $this->Need->upload_articals_images($request);
    }

    public function upload_files(Request $request)
    {
        return $this->Need->upload_files($request);
    }

    

}
