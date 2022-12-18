<?php

namespace App\Repository;

interface ServiceRepositoryInterface
{
    public function index();

    public function create();

    public function edit($id);

    public function show($id);

    public function update($request);

    public function destroy($id);

    public function servicesShow();

    public function serviceStore($request);

    public function getServiceById($id);

    public function updateServices($request);

    public function destroyServices($id);

    public function programsShow();

    public function programsStore($request);

    public function getProgramsById($id);

    public function updatePrograms($request);

    public function destroyPrograms($id);


    public function mysessionsStore($request);

    public function mysessionsShow();


    public function upload_image($request);

    public function upload_files($request);

    public function upload_images($request);

    public function upload_articals_images($request);
}
