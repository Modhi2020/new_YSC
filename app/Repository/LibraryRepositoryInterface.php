<?php

namespace App\Repository;

interface LibraryRepositoryInterface
{
    public function index();

    public function create();

    public function edit($id);

    public function show($id);

    public function update($request);

    public function destroy($id);

    public function librariesShow();

    public function libraryStore($request);

    public function updateLibraries($request);

    public function destroylibrary($id);

    public function getLibraryById($id);

    public function updateCourses($request);

    public function destroycourse($id);

    public function getCourseById($id);

    public function versionsShow();

    public function versionsStore($request);

    public function updateversions($request);

    public function destroyversions($id);

    public function getVersionById($id);

    public function coursesShow();

    public function coursesStore($request);

    public function videosShow();

    public function videosStore($request);

    public function updatevideos($request);

    public function destroyvideos($id);

    public function getVideosById($id);


}
