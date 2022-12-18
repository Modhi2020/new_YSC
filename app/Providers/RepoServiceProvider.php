<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepoServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind('App\Repository\TaskRepositoryInterface', 'App\Repository\TaskRepository');
        $this->app->bind('App\Repository\MediaRepositoryInterface', 'App\Repository\MediaRepository');
        $this->app->bind('App\Repository\RevenueExportRepositoryInterface', 'App\Repository\RevenueExportRepository');
        $this->app->bind('App\Repository\LibraryRepositoryInterface', 'App\Repository\LibraryRepository');
        $this->app->bind('App\Repository\ServiceRepositoryInterface', 'App\Repository\ServiceRepository');
        $this->app->bind('App\Repository\AboutusRepositoryInterface', 'App\Repository\AboutusRepository');
        $this->app->bind('App\Repository\ObjectivesRepositoryInterface', 'App\Repository\ObjectivesRepository');
        $this->app->bind('App\Repository\TeamRepositoryInterface', 'App\Repository\TeamRepository');
        $this->app->bind('App\Repository\OpportunityRepositoryInterface', 'App\Repository\OpportunityRepository');
        $this->app->bind('App\Repository\ContactsRepositoryInterface', 'App\Repository\ContactsRepository');
        $this->app->bind('App\Repository\NeedRepositoryInterface', 'App\Repository\NeedRepository');
        $this->app->bind('App\Repository\DocumentationRepositoryInterface', 'App\Repository\DocumentationRepository');
        $this->app->bind('App\Repository\QuestionsRepositoryInterface', 'App\Repository\QuestionsRepository');

    }
    


    public function boot()
    {
        //
    }
}
