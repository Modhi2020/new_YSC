<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\LibraryRepositoryInterface;
use Validator;

class LibraryController extends Controller
{
    protected $Library;

    public function __construct(LibraryRepositoryInterface $Library)
    {
        $this->Library =$Library;
    }

    public function index()
    {
        return $this->Library->index();
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
        return $this->Library->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->Library->edit($id);
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
        return $this->Library->update($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->Library->destroy($id);
    }

       
    public function librariesShow()
    {
        return $this->Library->librariesShow();
    }

    public function libraryStore(Request $request)
    {
        return $this->Library->libraryStore($request);
    }

    public function getLibraryById($id)
    {
        return $this->Library->getLibraryById($id);
    }

    public function updateLibraries(Request $request)
    {
        return $this->Library->updateLibraries($request);
    }

    public function destroylibrary($id)
    {
        return $this->Library->destroylibrary($id);
    }

    public function versionsShow()
    {
        return $this->Library->versionsShow();
    }

    public function versionsStore(Request $request)
    {
        return $this->Library->versionsStore($request);
    }

    public function getVersionById($id)
    {
        return $this->Library->getVersionById($id);
    }

    public function updateversions(Request $request)
    {
        return $this->Library->updateversions($request);
    }

    public function destroyversions($id)
    {
        return $this->Library->destroyversions($id);
    }

    public function coursesShow()
    {
        return $this->Library->coursesShow();
    }

    public function coursesStore(Request $request)
    {
        return $this->Library->coursesStore($request);
    }
    
    public function getCourseById($id)
    {
        return $this->Library->getCourseById($id);
    }

    public function updateCourses(Request $request)
    {
        return $this->Library->updateCourses($request);
    }

    public function destroycourse($id)
    {
        return $this->Library->destroycourse($id);
    }

    public function videosShow()
    {
        return $this->Library->videosShow();
    }

    public function videosStore(Request $request)
    {
        return $this->Library->videosStore($request);
    }

    public function getVideosById($id)
    {
        return $this->Library->getVideosById($id);
    }

    public function updatevideos(Request $request)
    {
        return $this->Library->updatevideos($request);
    }

    public function destroyvideos($id)
    {
        return $this->Library->destroyvideos($id);
    }

    public function upload_image(Request $request)
    {
        return $this->Library->upload_image($request);
    }

    public function upload_images(Request $request)  
    {
        return $this->Library->upload_images($request);
    }

    public function upload_articals_images(Request $request)  
    {
        return $this->Library->upload_articals_images($request);
    }

    public function upload_files(Request $request)
    {
        return $this->Library->upload_files($request);
    }

    

}
