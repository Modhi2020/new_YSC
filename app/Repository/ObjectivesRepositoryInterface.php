<?php

namespace App\Repository;

interface ObjectivesRepositoryInterface
{
    public function index();

    public function create();

    public function edit($id);

    public function store($request);

    public function show($id);

    public function update($request);

    public function destroy($id);

    public function objectivesShow();

}
