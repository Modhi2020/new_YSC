<?php

namespace App\Repository;

interface TaskRepositoryInterface
{
    public function index();

    public function create();

    public function store($request);

    public function edit($id);

    public function show($id);

    public function update($request);

    public function destroy($id);

    public function TasksShow();

    public function upload_image($request);

    public function upload_files($request);

    public function upload_images($request);
}
