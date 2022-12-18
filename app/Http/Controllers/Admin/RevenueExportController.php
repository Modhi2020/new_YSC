<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\RevenueExportRepositoryInterface;
use Validator;

class RevenueExportController extends Controller
{
    protected $RevenueExport;

    public function __construct(RevenueExportRepositoryInterface $RevenueExport)
    {
        $this->RevenueExport =$RevenueExport;
    }

    public function index()
    {
        return $this->RevenueExport->index();
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
        return $this->RevenueExport->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->RevenueExport->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->RevenueExport->edit($id);
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
        return $this->RevenueExport->update($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->RevenueExport->destroy($id);
    }

       
    public function NewsShow()
    {
        return $this->RevenueExport->NewsShow();
    }

    public function upload_image(Request $request)
    {
        return $this->RevenueExport->upload_image($request);
    }

    public function upload_images(Request $request)  
    {
        return $this->RevenueExport->upload_images($request);
    }

    public function upload_articals_images(Request $request)  
    {
        return $this->RevenueExport->upload_articals_images($request);
    }

    public function upload_files(Request $request)
    {
        return $this->RevenueExport->upload_files($request);
    }

    public function getArticalById($id)
    {
        return $this->RevenueExport->getArticalById($id);
    }

    public function articalsStore(Request $request)
    {
        return $this->RevenueExport->articalsStore($request);
    }

    public function ArticalsShow()
    {
        return $this->RevenueExport->ArticalsShow();
    }

    public function updateArtical(Request $request)
    {
        return $this->RevenueExport->updateArtical($request);
    }

    public function getStoriesById($id)
    {
        return $this->RevenueExport->getStoriesById($id);
    }

    public function incomingsStore(Request $request)
    {
        return $this->RevenueExport->incomingsStore($request);
    }

    public function incomingsShow()
    {
        return $this->RevenueExport->incomingsShow();
    }

    public function updateStories(Request $request)
    {
        return $this->RevenueExport->updateStories($request);
    }

    public function outcomingsStore(Request $request)
    {
        return $this->RevenueExport->outcomingsStore($request);
    }

    public function outcomingsShow()
    {
        return $this->RevenueExport->outcomingsShow();
    }

    public function sideStore(Request $request)
    {
        return $this->RevenueExport->sideStore($request);
    }

    public function sidesShow()
    {
        return $this->RevenueExport->sidesShow();
    }

    public function incoutquery(Request $request)
    {
        return $this->RevenueExport->incoutquery($request);
    }

    public function select_outcoming_no()
    {
        return $this->RevenueExport->select_outcoming_no();
    }

    public function select_incoming_no()
    {
        return $this->RevenueExport->select_incoming_no();
    }

}
