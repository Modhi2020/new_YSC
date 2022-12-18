<?php

namespace App\Repository;

interface NeedRepositoryInterface
{
    public function index();

    public function create();

    public function edit($id);

    public function show($id);

    public function update($request);

    public function destroy($id);

    public function opportunitiesShow();

    public function opportunitiesStore($request);

    public function mosquesShow();

    public function mosquesStore($request);

    public function AssginmosquesToOpportunity($request);

    public function preachersStore($request);

    public function preachersShow();


    public function upload_image($request);

    public function upload_files($request);

    public function upload_images($request);

    public function upload_articals_images($request);
}
