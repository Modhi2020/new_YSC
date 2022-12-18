<?php

namespace App\Repository;

interface RevenueExportRepositoryInterface
{
    public function index();

    public function create();

    public function store($request);

    public function edit($id);

    public function show($id);

    public function update($request);

    public function destroy($id);

    public function NewsShow();

    public function upload_image($request);

    public function upload_files($request);

    public function upload_images($request);

    public function getArticalById($id);

    public function articalsStore($request);

    public function ArticalsShow();

    public function updateArtical($request);

    public function getStoriesById($id);

    public function incomingsStore($request);

    public function incomingsShow();

    public function updateStories($request);

    public function upload_articals_images($request);

    public function outcomingsStore($request);

    public function outcomingsShow();

    public function sideStore($request);

    public function sidesShow();

    public function incoutquery($request);

    public function select_outcoming_no();
    
    public function select_incoming_no();
}
