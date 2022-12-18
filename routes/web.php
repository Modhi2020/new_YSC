<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


    // Route::get('modhi', function () {
    //     return view('pages.index');
      
    // });

    
    Route::get('modhi', function () {
        $exitcode = Artisan::call('route:cache');
        $exitcode = Artisan::call('route:clear');
        $exitcode = Artisan::call('cache:clear');
        $exitcode = Artisan::call('config:cache');
     
        $exitcode = Artisan::call('view:clear');
        $exitcode = Artisan::call('optimize');
        $exitcode = Artisan::call('event:cache');
        $exitcode = Artisan::call('event:clear');
        return 'Modhi';
        // return view('pages.index');
        // return view('auth.login');
    });

    Route::get('modhimb', function () {
        $exitcode = Artisan::call('cache:clear');
        $exitcode = Artisan::call('config:cache');
     
        $exitcode = Artisan::call('view:clear');
        $exitcode = Artisan::call('event:cache');
        $exitcode = Artisan::call('event:clear');
        return 'Modhi';
        // return view('pages.index');
        // return view('auth.login');
    });
    
    
    Route::get('/mb', function () {
        $exitcode = Artisan::call('storage:link');
    });

    Route::get('/ajax_upload', 'AjaxUploadController@index');

Route::post('/ajax_upload/action', 'AjaxUploadController@action')->name('ajaxupload.action');

// multi images //
Route::get('multiple-image-preview','AjaxUploadMultipleImageController@index'); 

Route::post('upload-multiple-image-ajax','AjaxUploadMultipleImageController@saveUpload'); 


// files //
Route::get('multi-file-ajax-upload','MultiFileUploadAjaxController@index'); 

Route::post('store-multi-file-ajax','MultiFileUploadAjaxController@storeMultiFile'); 





Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ], function () {


    

        // FRONT-END ROUTES
Route::get('/', 'FrontpageController@index')->name('home');

Route::get('/mymedia', 'MyMediaController@mymedia')->name('mymedia');

Route::get('/slider', 'FrontpageController@slider')->name('slider.index');

Route::get('/search', 'FrontpageController@search')->name('search');

Route::resource('testimonials','TestimonialController');

Route::get('/share', 'ShareButtonController@share');

Route::get('/property', 'PagesController@properties')->name('property');
Route::get('/property/{id}', 'PagesController@propertieshow')->name('property.show');
Route::post('/property/message', 'PagesController@messageAgent')->name('property.message');
Route::post('/property/comment/{id}', 'PagesController@propertyComments')->name('property.comment');
Route::post('/property/rating', 'PagesController@propertyRating')->name('property.rating');
Route::get('/property/city/{catslug}', 'PagesController@propertyCities')->name('property.city');

Route::get('/news', 'PagesController@news')->name('news');
Route::get('/news/{id}', 'PagesController@newsshow')->name('news.show');
Route::post('/news/rating', 'PagesController@newsRating')->name('news.rating');
Route::post('/news/likes', 'PagesController@newsLikes')->name('news.likes');
Route::post('/news/comment/{id}', 'PagesController@newsComments')->name('news.comment');
Route::get('/news/category/{cat_slug}', 'PagesController@newsCategory')->name('news.category');

Route::get('/articles', 'PagesController@articles')->name('articles');
Route::get('/articles/{id}', 'PagesController@articlesshow')->name('articles.show');
Route::post('/articles/rating', 'PagesController@articlesRating')->name('articles.rating');
Route::post('/articles/comment/{id}', 'PagesController@articlesComments')->name('articles.comment');
Route::get('/articles/category/{cat_slug}', 'PagesController@articlesCategory')->name('articles.category');


Route::get('/stories', 'PagesController@stories')->name('stories');
Route::get('/stories/{id}', 'PagesController@storiesshow')->name('stories.show');
Route::get('/stories/category/{cat_slug}', 'PagesController@storiesCategory')->name('stories.category');

Route::get('/aboutus', 'PagesController@aboutus')->name('aboutus');


Route::view('select_Opportunities','livewire.mbmb')->name('select_Opportunities');
Route::view('counter', 'livewire.counter');

Route::get('/select_Opportunity', 'PagesController@select_Opportunity')->name('select_Opportunity');
Route::get('/opportunity/{id}', 'PagesController@opportunityshow')->name('opportunity.show');

Route::get('/courses', 'PagesController@courses')->name('courses');
Route::get('/courses/{id}', 'PagesController@coursesshow')->name('courses.show');

Route::get('/agents', 'PagesController@agents')->name('agents');
Route::get('/agents/{id}', 'PagesController@agentshow')->name('agents.show');

Route::get('/myservices', 'PagesController@myservices')->name('myservices');
Route::get('/myservicesshow/{id}', 'PagesController@myservicesshow')->name('myservicesshow');

Route::get('/myprograms', 'PagesController@myprograms')->name('myprograms');
Route::get('/myprogramsshow/{id}', 'PagesController@myprogramsshow')->name('myprogramsshow');


Route::get('/myversions', 'PagesController@myversions')->name('myversions');
Route::get('/myversionsshow/{id}/{type}', 'PagesController@myversionsshow')->name('myversionsshow');

Route::get('/gallery', 'PagesController@gallery')->name('gallery');

Route::get('/myevents', 'PagesController@myevents')->name('myevents');
Route::get('/appdownload/{id}', 'PagesController@appdownload');

Route::get('/blog', 'PagesController@blog')->name('blog');
Route::get('/blog/{id}', 'PagesController@blogshow')->name('blog.show');
Route::post('/blog/comment/{id}', 'PagesController@blogComments')->name('blog.comment');

Route::get('/blog/categories/{slug}', 'PagesController@blogCategories')->name('blog.categories');
Route::get('/blog/tags/{slug}', 'PagesController@blogTags')->name('blog.tags');
Route::get('/blog/author/{username}', 'PagesController@blogAuthor')->name('blog.author');

Route::get('/contact', 'PagesController@contact')->name('contact');
Route::post('/contact', 'PagesController@messageContact')->name('contact.message');

Auth::routes();

});


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath','auth','admin','CheckUserStatus']
    ], function () {



Route::group(['prefix'=>'admin','namespace'=>'Admin','as'=>'admin.'], function(){

    Route::get('dashboard','DashboardController@index')->name('dashboard');
    Route::resource('tags','TagController');
    Route::resource('cities','CityController');
    Route::resource('categories','CategoryController');
    Route::resource('posts','PostController');
    Route::resource('features','FeatureController');
    Route::resource('properties','PropertyController');
    Route::post('properties/gallery/delete','PropertyController@galleryImageDelete')->name('gallery-delete');

    Route::resource('sliders','SliderController');
    Route::resource('testimonials','TestimonialController');

    Route::resource('regions','RegionController');
    Route::resource('occupations','OccupationController');

    //==============================Tasks============================
    Route::resource('tasks', 'TaskController');
    Route::get('add_tasks','TaskController@store')->name('add_tasks');
    Route::get('TasksShow','TaskController@TasksShow')->name('TasksShow');
    Route::get('/editTasks','TaskController@update')->name('editTasks');
    Route::get('/getTaskById/{id}','TaskController@edit')->name('getTaskById');
    Route::get('/deleteTasks/{id}','TaskController@destroy')->name('deleteTasks');
    Route::post('/tasks/upload_image', 'TaskController@upload_image')->name('tasks.upload_image');
    Route::post('/tasks/upload_images','TaskController@upload_images'); 
    Route::post('/tasks/upload_files','TaskController@upload_files'); 

//================= Media ==========================
    Route::resource('medias','MediaController');
    Route::post('/news/add_news','MediaController@store'); 
    Route::post('/media/upload_images','MediaController@upload_images'); 
    Route::get('NewsShow','MediaController@NewsShow')->name('NewsShow');
    Route::get('/getNewsById/{id}','MediaController@edit')->name('getNewsById');
    Route::post('/news/update_news','MediaController@update');
    Route::get('/deleteNews/{id}','MediaController@destroy')->name('deleteNews');

//============== Articals ===========================
    Route::post('/articals/add_articals','MediaController@articalsStore'); 
    Route::get('ArticalsShow','MediaController@ArticalsShow')->name('ArticalsShow');
    Route::get('/getArticalById/{id}','MediaController@getArticalById')->name('getArticalById');
    Route::post('/articals/update_artical','MediaController@updateArtical');
    Route::get('/destroyArtical/{id}','MediaController@destroyArtical')->name('destroyArtical');

//============== Stories ===========================
    Route::post('/stories/add_stories','MediaController@StoriesStore'); 
    Route::get('storiesShow','MediaController@StoriesShow')->name('StoriesShow');
    Route::get('/getStoriesById/{id}','MediaController@getStoriesById')->name('getStoriesById');
    Route::post('/stories/update_stories','MediaController@updateStories');
    Route::get('/destroyStories/{id}','MediaController@destroyStories')->name('destroyStories');

   //============== Aboutus ===========================
   Route::resource('aboutus','AboutuController');
   Route::post('/aboutus/add_aboutus','AboutuController@store');
   Route::get('aboutusShow','AboutuController@aboutusShow')->name('aboutusShow');
   Route::get('/getAboutusById/{id}','AboutuController@edit')->name('getAboutusById');
   Route::post('/updateaboutus','AboutuController@update');
   Route::get('/destroyaboutus/{id}','AboutuController@destroy')->name('destroyaboutus');


  //============== Objectives ===========================
   Route::resource('objectives','ObjectiveController');
   Route::post('/objectives/add_objectives','ObjectiveController@store');
   Route::get('objectivesShow','ObjectiveController@objectivesShow')->name('objectivesShow');
   Route::get('/getObjectiveById/{id}','ObjectiveController@edit')->name('getObjectiveById');
   Route::post('/updateobjectives','ObjectiveController@update');
   Route::get('/destroyobjectives/{id}','ObjectiveController@destroy')->name('destroyobjectives');

    //============== teams ===========================
    Route::resource('teams','TeamController');
    Route::post('/teams/add_teams','TeamController@store');
    Route::get('teamsShow','TeamController@teamsShow')->name('teamsShow');
    Route::get('/getTeamsById/{id}','TeamController@edit')->name('getTeamsById');
    Route::post('/updateteams','TeamController@update');
    Route::get('/destroyteams/{id}','TeamController@destroy')->name('destroyteams');
   
  //============== Contacts ===========================
    Route::resource('contacts','ContactController');
    
   //============== Versions ===========================
    Route::resource('versions','LibraryController');
    Route::post('/libraries/add_book','LibraryController@libraryStore'); 
    Route::get('librariesShow','LibraryController@librariesShow')->name('librariesShow');
    Route::get('/getLibraryById/{id}','LibraryController@getLibraryById')->name('getLibraryById');
    Route::post('/updateLibraries','LibraryController@updateLibraries');
    Route::get('/destroylibrary/{id}','LibraryController@destroylibrary')->name('destroylibrary');

    Route::post('/versions/add_book','LibraryController@versionsStore'); 
    Route::get('versionsShow','LibraryController@versionsShow')->name('versionsShow');
    Route::get('/getVersionById/{id}','LibraryController@getVersionById')->name('getVersionById');
    Route::post('/updateversions','LibraryController@updateversions');
    Route::get('/destroyversions/{id}','LibraryController@destroyversions')->name('destroyversions');

    Route::post('/courses/add_courses','LibraryController@coursesStore'); 
    Route::get('coursesShow','LibraryController@coursesShow')->name('coursesShow');
    Route::get('/getCourseById/{id}','LibraryController@getCourseById')->name('getCourseById');
    Route::post('/updateCourses','LibraryController@updateCourses');
    Route::get('/destroycourse/{id}','LibraryController@destroycourse')->name('destroycourse');

    Route::post('/videos/add_videos','LibraryController@videosStore'); 
    Route::get('videosShow','LibraryController@videosShow')->name('videosShow');
    Route::get('/getVideosById/{id}','LibraryController@getVideosById')->name('getVideosById');
    Route::post('/updatevideos','LibraryController@updatevideos');
    Route::get('/destroyvideos/{id}','LibraryController@destroyvideos')->name('destroyvideos');

    //============== Services ===========================
    Route::resource('services','ServiceController');
    Route::post('/services/add_services','ServiceController@serviceStore'); 
    Route::get('servicesShow','ServiceController@servicesShow')->name('servicesShow');
    Route::get('/getServiceById/{id}','ServiceController@getServiceById')->name('getServiceById');
    Route::post('/update_services','ServiceController@updateServices');
    Route::get('/destroyServices/{id}','ServiceController@destroyServices')->name('destroyServices');

    Route::post('/programs/add_programs','ServiceController@programsStore'); 
    Route::get('programsShow','ServiceController@programsShow')->name('programsShow');
    Route::get('/getProgramsById/{id}','ServiceController@getProgramsById')->name('getProgramsById');
    Route::post('/updatePrograms','ServiceController@updatePrograms');
    Route::get('/destroyPrograms/{id}','ServiceController@destroyPrograms')->name('destroyPrograms');
    Route::post('/mysessions/add_mysessions','ServiceController@mysessionsStore'); 
    Route::get('mysessionsShow','ServiceController@mysessionsShow')->name('mysessionsShow');

    //============== Opportunities ===========================
    Route::resource('opportunities','OpportunityController');
    Route::post('/opportunities/add_opportunities','OpportunityController@opportunitiesStore'); 
    Route::get('opportunitiesShow','OpportunityController@opportunitiesShow')->name('opportunitiessShow');
    Route::get('/getOpportunityById/{id}','OpportunityController@getOpportunityById')->name('getOpportunityById');
    Route::post('/updateopportunities','OpportunityController@updateopportunities');
    Route::get('/destroyopportunity/{id}','OpportunityController@destroyopportunity')->name('destroyopportunity');

    Route::post('/surveys/add_surveys','OpportunityController@surveysStore'); 
    Route::get('surveysShow','OpportunityController@surveysShow')->name('surveysShow');
    Route::get('/getSurveysById/{id}','OpportunityController@getSurveysById')->name('getSurveysById');
    Route::post('/updatesurveys','OpportunityController@updatesurveys');
    Route::get('/destroysurvey/{id}','OpportunityController@destroysurvey')->name('destroysurvey');

    Route::get('AssginSurveysToOpportunity', 'OpportunityController@AssginSurveysToOpportunity')->name('AssginSurveysToOpportunity');

    //============== Questions ===========================
    Route::resource('questions','QuestionsController');

//================= Revenue_Exports ==========================
    Route::resource('revenue_exports','RevenueExportController');
    Route::post('/incomings/add_incomings','RevenueExportController@incomingsStore'); 
    Route::post('/outcomings/add_outcomings','RevenueExportController@outcomingsStore'); 
    Route::post('/sides/add_side','RevenueExportController@sideStore'); 
    // Route::post('/media/upload_images','MediaController@upload_images'); 
    Route::get('incomingsShow','RevenueExportController@incomingsShow')->name('incomingsShow');
    Route::get('outcomingsShow','RevenueExportController@outcomingsShow')->name('outcomingsShow');
    Route::get('sidesShow','RevenueExportController@sidesShow')->name('sidesShow');
    Route::post('/incoutquery','RevenueExportController@incoutquery'); 
    Route::get('/select_outcoming_no','RevenueExportController@select_outcoming_no'); 
    Route::get('/select_incoming_no','RevenueExportController@select_incoming_no'); 

    //================= Revenue_Exports ==========================
    Route::resource('documentations','DocumentationController');

     //==============================Needs============================
     Route::resource('needs', 'NeedController');
     Route::post('/preachers/add_preachers','NeedController@preachersStore'); 
     Route::get('preachersShow','NeedController@preachersShow')->name('preachersShow');
     Route::post('/mosques/add_mosques','NeedController@mosquesStore'); 
     Route::get('mosquesShow','NeedController@mosquesShow')->name('mosquesShow');

     //============ Permession =================================================
     Route::resource('roles','RoleController');
     Route::resource('users','UserController');
     Route::resource('departments','DepartmentController');
     Route::get('/myRoles/{id}', 'UserController@getclasses');
     Route::get('/getUserType/{id}', 'UserController@getUserType');
     Route::get('/get_departments/{id}', 'DepartmentController@get_departments');

    Route::get('galleries/album','GalleryController@album')->name('album');
    Route::post('galleries/album/store','GalleryController@albumStore')->name('album.store');
    Route::get('galleries/{id}/gallery','GalleryController@albumGallery')->name('album.gallery');
    Route::post('galleries','GalleryController@Gallerystore')->name('galleries.store');

    Route::get('settings', 'DashboardController@settings')->name('settings');
    Route::post('settings', 'DashboardController@settingStore')->name('settings.store');

    Route::get('profile','DashboardController@profile')->name('profile');
    Route::post('profile','DashboardController@profileUpdate')->name('profile.update');

    Route::get('message','DashboardController@message')->name('message');
    Route::get('message/read/{id}','DashboardController@messageRead')->name('message.read');
    Route::get('message/replay/{id}','DashboardController@messageReplay')->name('message.replay');
    Route::post('message/replay','DashboardController@messageSend')->name('message.send');
    Route::post('message/readunread','DashboardController@messageReadUnread')->name('message.readunread');
    Route::delete('message/delete/{id}','DashboardController@messageDelete')->name('messages.destroy');
    Route::post('message/mail', 'DashboardController@contactMail')->name('message.mail');

    Route::get('changepassword','DashboardController@changePassword')->name('changepassword');
    Route::post('changepassword','DashboardController@changePasswordUpdate')->name('changepassword.update');

});
});

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath','auth','agent','CheckUserStatus']
    ], function () {

Route::group(['prefix'=>'agent','namespace'=>'Agent','as'=>'agent.'], function(){

    Route::get('dashboard','DashboardController@index')->name('dashboard');
    Route::get('profile','DashboardController@profile')->name('profile');
    Route::post('profile','DashboardController@profileUpdate')->name('profile.update');
    Route::get('changepassword','DashboardController@changePassword')->name('changepassword');
    Route::post('changepassword','DashboardController@changePasswordUpdate')->name('changepassword.update');
    Route::resource('properties','PropertyController');
    Route::post('properties/gallery/delete','PropertyController@galleryImageDelete')->name('gallery-delete');

    Route::get('message','DashboardController@message')->name('message');
    Route::get('message/read/{id}','DashboardController@messageRead')->name('message.read');
    Route::get('message/replay/{id}','DashboardController@messageReplay')->name('message.replay');
    Route::post('message/replay','DashboardController@messageSend')->name('message.send');
    Route::post('message/readunread','DashboardController@messageReadUnread')->name('message.readunread');
    Route::delete('message/delete/{id}','DashboardController@messageDelete')->name('messages.destroy');
    Route::post('message/mail', 'DashboardController@contactMail')->name('message.mail');

});
});

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath','auth','user','CheckUserStatus']
    ], function () {

Route::group(['prefix'=>'user','namespace'=>'User','as'=>'user.'], function(){

    Route::get('dashboard','DashboardController@index')->name('dashboard');
    Route::get('profile','DashboardController@profile')->name('profile');
    Route::post('profile','DashboardController@profileUpdate')->name('profile.update');
    Route::get('changepassword','DashboardController@changePassword')->name('changepassword');
    Route::post('changepassword','DashboardController@changePasswordUpdate')->name('changepassword.update');

    Route::get('message','DashboardController@message')->name('message');
    Route::get('message/read/{id}','DashboardController@messageRead')->name('message.read');
    Route::get('message/replay/{id}','DashboardController@messageReplay')->name('message.replay');
    Route::post('message/replay','DashboardController@messageSend')->name('message.send');
    Route::post('message/readunread','DashboardController@messageReadUnread')->name('message.readunread');
    Route::delete('message/delete/{id}','DashboardController@messageDelete')->name('messages.destroy');

});
});