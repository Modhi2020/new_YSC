<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\MediaRepositoryInterface;
use Validator;

class MediaController extends Controller
{
    protected $Media;

    public function __construct(MediaRepositoryInterface $Media)
    {
        $this->Media =$Media;
    }

    public function index()
    {
        return $this->Media->index();
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
        return $this->Media->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->Media->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->Media->edit($id);
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
        return $this->Media->update($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->Media->destroy($id);
    }

       
    public function NewsShow()
    {
        return $this->Media->NewsShow();
    }

    public function upload_image(Request $request)
    {
        return $this->Media->upload_image($request);
    }

    public function upload_images(Request $request)  
    {
        return $this->Media->upload_images($request);
    }

    public function upload_articals_images(Request $request)  
    {
        return $this->Media->upload_articals_images($request);
    }

    public function upload_files(Request $request)
    {
        return $this->Media->upload_files($request);
    }

    public function getArticalById($id)
    {
        return $this->Media->getArticalById($id);
    }

    public function articalsStore(Request $request)
    {
        return $this->Media->articalsStore($request);
    }

    public function ArticalsShow()
    {
        return $this->Media->ArticalsShow();
    }

    public function updateArtical(Request $request)
    {
        return $this->Media->updateArtical($request);
    }

    public function destroyArtical($id)
    {
        return $this->Media->destroyArtical($id);
    }

    public function getStoriesById($id)
    {
        return $this->Media->getStoriesById($id);
    }

    public function StoriesStore(Request $request)
    {
        return $this->Media->StoriesStore($request);
    }

    public function StoriesShow()
    {
        return $this->Media->StoriesShow();
    }

    public function updateStories(Request $request)
    {
        return $this->Media->updateStories($request);
    }

    public function destroyStories($id)
    {
        return $this->Media->destroyStories($id);
    }
}
