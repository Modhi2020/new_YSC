<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\OpportunityRepositoryInterface;
use Validator;

class OpportunityController extends Controller
{
    protected $Opportunity;

    public function __construct(OpportunityRepositoryInterface $Opportunity)
    {
        $this->Opportunity =$Opportunity;
    }

    public function index()
    {
        return $this->Opportunity->index();
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
        return $this->Opportunity->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->Opportunity->edit($id);
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
        return $this->Opportunity->update($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->Opportunity->destroy($id);
    }


    public function opportunitiesStore(Request $request)
    {
        return $this->Opportunity->opportunitiesStore($request);
    }

    public function opportunitiesShow()
    {
        return $this->Opportunity->opportunitiesShow();
    }

    public function getOpportunityById($id)
    {
        return $this->Opportunity->getOpportunityById($id);
    }

    public function updateopportunities(Request $request)
    {
        return $this->Opportunity->updateopportunities($request);
    }

    public function destroyopportunity($id)
    {
        return $this->Opportunity->destroyopportunity($id);
    }

    public function surveysStore(Request $request)
    {
          
        return $this->Opportunity->surveysStore($request);
    }

    public function surveysShow()
    {
        return $this->Opportunity->surveysShow();
    }

    public function getSurveysById($id)
    {
        return $this->Opportunity->getSurveysById($id);
    }

    public function updatesurveys(Request $request)
    {
        return $this->Opportunity->updatesurveys($request);
    }

    public function destroysurvey($id)
    {
        return $this->Opportunity->destroysurvey($id);
    }
    
    public function AssginSurveysToOpportunity(Request $request)
    {          
        return $this->Opportunity->AssginSurveysToOpportunity($request);
    }

    

    public function upload_image(Request $request)
    {
        return $this->Opportunity->upload_image($request);
    }

    public function upload_images(Request $request)  
    {
        return $this->Opportunity->upload_images($request);
    }

    public function upload_articals_images(Request $request)  
    {
        return $this->Opportunity->upload_articals_images($request);
    }

    public function upload_files(Request $request)
    {
        return $this->Opportunity->upload_files($request);
    }

    

}
