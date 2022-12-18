<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\DocumentationRepositoryInterface;
use Validator;

class DocumentationController extends Controller
{
    protected $Documentation;

    public function __construct(DocumentationRepositoryInterface $Documentation)
    {
        $this->Documentation =$Documentation;
    }

    public function index()
    {
        return $this->Documentation->index();
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
        return $this->Documentation->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->Documentation->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->Documentation->edit($id);
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
        return $this->Documentation->update($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->Documentation->destroy($id);
    }

       
    public function NewsShow()
    {
        return $this->Documentation->NewsShow();
    }

    public function upload_image(Request $request)
    {
        return $this->Documentation->upload_image($request);
    }

    public function upload_images(Request $request)  
    {
        return $this->Documentation->upload_images($request);
    }

    public function upload_articals_images(Request $request)  
    {
        return $this->Documentation->upload_articals_images($request);
    }

    public function upload_files(Request $request)
    {
        return $this->Documentation->upload_files($request);
    }

    public function getArticalById($id)
    {
        return $this->Documentation->getArticalById($id);
    }

    public function articalsStore(Request $request)
    {
        return $this->Documentation->articalsStore($request);
    }

    public function ArticalsShow()
    {
        return $this->Documentation->ArticalsShow();
    }

    public function updateArtical(Request $request)
    {
        return $this->Documentation->updateArtical($request);
    }

    public function getStoriesById($id)
    {
        return $this->Documentation->getStoriesById($id);
    }

    public function incomingsStore(Request $request)
    {
        return $this->Documentation->incomingsStore($request);
    }

    public function incomingsShow()
    {
        return $this->Documentation->incomingsShow();
    }

    public function updateStories(Request $request)
    {
        return $this->Documentation->updateStories($request);
    }

    public function outcomingsStore(Request $request)
    {
        return $this->Documentation->outcomingsStore($request);
    }

    public function outcomingsShow()
    {
        return $this->Documentation->outcomingsShow();
    }

    public function sideStore(Request $request)
    {
        return $this->Documentation->sideStore($request);
    }

    public function sidesShow()
    {
        return $this->Documentation->sidesShow();
    }

    public function incoutquery(Request $request)
    {
        return $this->Documentation->incoutquery($request);
    }

    public function select_outcoming_no()
    {
        return $this->Documentation->select_outcoming_no();
    }

    public function select_incoming_no()
    {
        return $this->Documentation->select_incoming_no();
    }

}
