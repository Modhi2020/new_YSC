<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\TaskRepositoryInterface;
use Validator;

class TaskController extends Controller
{
    protected $Task;

    public function __construct(TaskRepositoryInterface $Task)
    {
        $this->Task =$Task;
    }

    public function index()
    {
        return $this->Task->index();
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
        return $this->Task->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->Task->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->Task->edit($id);
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
        return $this->Task->update($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->Task->destroy($id);
    }

    
    public function TasksShow()
    {
        return $this->Task->TasksShow();
    }

    public function upload_image(Request $request)
    {
        return $this->Task->upload_image($request);
    }

    public function upload_images(Request $request)  
    {
        return $this->Task->upload_images($request);
    }

    public function upload_files(Request $request)
    {
        return $this->Task->upload_files($request);
    }


}
