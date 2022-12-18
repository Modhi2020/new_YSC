<?php

namespace App\Repository;

interface QuestionsRepositoryInterface
{
    public function index();

    public function create();

    public function edit($id);

    public function show($id);

    public function update($request);

    public function destroy($id);

    public function opportunitiesShow();

    public function opportunitiesStore($request);

    public function updateopportunities($request);

    public function destroyopportunity($id);

    public function getOpportunityById($id);

    public function surveysShow();

    public function surveysStore($request);

    public function updatesurveys($request);

    public function destroysurvey($id);

    public function getSurveysById($id);

    public function AssginSurveysToOpportunity($request);

    public function mysessionsStore($request);

    public function mysessionsShow();


    public function upload_image($request);

    public function upload_files($request);

    public function upload_images($request);

    public function upload_articals_images($request);
}
