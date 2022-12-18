<?php

namespace App\Repository;

interface ContactsRepositoryInterface
{
    public function index();

    public function create();

    public function edit($id);

    public function store($request);

    public function show($id);

    public function aboutusShow();

    public function update($request);

    public function destroy($id);

}
