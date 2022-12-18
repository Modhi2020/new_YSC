<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;

use App\Models\Property;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Category;
use App\Models\Setting;
use App\Models\Contact;
use App\Models\Message;
use App\Models\PropertyType;
use App\Models\PropertyPurpose;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
       public function boot()
    {
        Schema::defaultStringLength(191);

        if (! $this->app->runningInConsole()) {

            // SHARE TO ALL ROUTES
            $bedroomdistinct  = Property::select('bedroom')->distinct()->get();
            view()->share('bedroomdistinct', $bedroomdistinct);

            $PropertyTypes  = PropertyType::select('name')->distinct()->get();
            view()->share('PropertyTypes', $PropertyTypes);

            $PropertyPurposes  = PropertyPurpose::select('name')->distinct()->get();
            view()->share('PropertyPurposes', $PropertyPurposes);

            $cities   = Property::select('city')->distinct()->get();
            $citylist = array();
            foreach($cities as $city){
                $citylist[$city['city']] = NULL;
            }
            view()->share('citylist', $citylist);


            // SHARE WITH SPECIFIC VIEW
            view()->composer('pages.search', function($view) {
                $view->with('bathroomdistinct', Property::select('bathroom')->distinct()->get());
                $view->with('PropertyTypes', PropertyType::select('name')->distinct()->get());
                $view->with('PropertyPurposes', PropertyPurpose::select('name')->distinct()->get());
            });

            view()->composer('frontend.partials.footer', function($view) {
                $view->with('footerproperties', Property::latest()->take(3)->get());
                $view->with('footercontacts', Contact::latest()->get());
                $view->with('footersettings', Setting::select('footer','aboutus','facebook','twitter','linkedin')->get());
            });

            view()->composer('frontend.partials.navbar', function($view) {
                $view->with('navbarsettings', Setting::select('name')->get());
            });

            view()->composer('backend.partials.navbar', function($view) {
                $view->with('countmessages', Message::latest()->where('agent_id', Auth::id())->count());
                $view->with('navbarmessages', Message::latest()->where('agent_id', Auth::id())->take(5)->get());
            });

            view()->composer('pages.contact', function($view) {
                $view->with('contactsettings', Setting::select('phone','email','address')->get());
            });

            view()->composer('pages.blog.sidebar', function($view) {

                $archives     = Post::archives();
                $categories   = Category::has('posts')->withCount('posts')->get();
                $tags         = Tag::has('posts')->get();
                $popularposts = Post::orderBy('view_count','desc')->take(5)->get();

                $view->with(compact('archives','categories','tags','popularposts'));
            });

        }
    }
}
