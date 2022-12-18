<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\QuestionsRepositoryInterface;
use Validator;

class QuestionsController extends Controller
{
    protected $Questions;

    public function __construct(QuestionsRepositoryInterface $Questions)
    {
        $this->Questions =$Questions;
    }

    public function index()
    {
        return $this->Questions->index();
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
        return $this->Questions->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->Questions->edit($id);
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
        return $this->Questions->update($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->Questions->destroy($id);
    }


    public function opportunitiesStore(Request $request)
    {
        return $this->Questions->opportunitiesStore($request);
    }

    public function opportunitiesShow()
    {
        return $this->Questions->opportunitiesShow();
    }

    public function getQuestionsById($id)
    {
        return $this->Questions->getQuestionsById($id);
    }

    public function updateopportunities(Request $request)
    {
        return $this->Questions->updateopportunities($request);
    }

    public function destroyQuestions($id)
    {
        return $this->Questions->destroyQuestions($id);
    }

    public function surveysStore(Request $request)
    {
          
        return $this->Questions->surveysStore($request);
    }

    public function surveysShow()
    {
        return $this->Questions->surveysShow();
    }

    public function getSurveysById($id)
    {
        return $this->Questions->getSurveysById($id);
    }

    public function updatesurveys(Request $request)
    {
        return $this->Questions->updatesurveys($request);
    }

    public function destroysurvey($id)
    {
        return $this->Questions->destroysurvey($id);
    }
    
    public function AssginSurveysToQuestions(Request $request)
    {          
        return $this->Questions->AssginSurveysToQuestions($request);
    }

    

    public function upload_image(Request $request)
    {
        return $this->Questions->upload_image($request);
    }

    public function upload_images(Request $request)  
    {
        return $this->Questions->upload_images($request);
    }

    public function upload_articals_images(Request $request)  
    {
        return $this->Questions->upload_articals_images($request);
    }

    public function upload_files(Request $request)
    {
        return $this->Questions->upload_files($request);
    }

    

}
