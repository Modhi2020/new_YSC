<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimonial;
use App\Models\Property;
use App\Models\Service;
use App\Models\Slider;
use App\Models\Post;
use App\Models\News;
use App\Models\Article;
use App\Models\Storie;
use App\Models\Course;
use App\Models\Library;
use App\Models\Video;
use App\Models\Opportunity;

class FrontpageController extends Controller
{
    
    public function index()
    {
        $data['sliders']       = Slider::latest()->get();
        $data['max_slider']     = Slider::orderBy('id','desc')->value('id');
        $data['properties']     = Property::latest()->where('featured',1)->with('rating')->withCount('comments')->take(6)->get();
        // $data['properties']     = Property::latest()->where('featured',1)->where('id',3)->with('rating')->withCount('comments')->get();
        $data['services']       = Service::orderBy('service_order')->take(6)->get();
        $data['testimonials']  = Testimonial::latest()->take(9)->get();
        $data['posts']          = Post::latest()->where('status',1)->take(6)->get();
        $data['News']  = News::with('category')->with('rating')->withCount('comments')->withCount('mylikes')->where('ready',1)->where('select',1)->latest()->take(3)->get();
        $data['Articles']  = Article::where('select',1)->latest()->take(6)->get();
        $data['Stories']  = Storie::where('select',1)->latest()->take(4)->get();
        $data['Courses']  = Course::where('select',1)->latest()->take(3)->get();
        $data['videos'] = Video::where('select',1)->latest()->paginate(2);
        $data['centerLibrary'] = Library::where('type', 1)->latest()->paginate(2);
        $data['myversions'] = Library::where('type', 2)->latest()->paginate(2);
        $data['opportunities']  = Opportunity::where('select',1)->latest()->take(6)->get();


        return view('frontend.index', $data);
    }


    public function search(Request $request)
    {
        $city     = strtolower($request->city);
        $type     = $request->type;
        $purpose  = $request->purpose;
        $bedroom  = $request->bedroom;
        $bathroom = $request->bathroom;
        $minprice = $request->minprice;
        $maxprice = $request->maxprice;
        $minarea  = $request->minarea;
        $maxarea  = $request->maxarea;
        $featured = $request->featured;

        $properties = Property::latest()->withCount('comments')
                                ->when($city, function ($query, $city) {
                                    return $query->where('city', '=', $city);
                                })
                                ->when($type, function ($query, $type) {
                                    return $query->where('type', '=', $type);
                                })
                                ->when($purpose, function ($query, $purpose) {
                                    return $query->where('purpose', '=', $purpose);
                                })
                                ->when($bedroom, function ($query, $bedroom) {
                                    return $query->where('bedroom', '=', $bedroom);
                                })
                                ->when($bathroom, function ($query, $bathroom) {
                                    return $query->where('bathroom', '=', $bathroom);
                                })
                                ->when($minprice, function ($query, $minprice) {
                                    return $query->where('price', '>=', $minprice);
                                })
                                ->when($maxprice, function ($query, $maxprice) {
                                    return $query->where('price', '<=', $maxprice);
                                })
                                ->when($minarea, function ($query, $minarea) {
                                    return $query->where('area', '>=', $minarea);
                                })
                                ->when($maxarea, function ($query, $maxarea) {
                                    return $query->where('area', '<=', $maxarea);
                                })
                                ->when($featured, function ($query, $featured) {
                                    return $query->where('featured', '=', 1);
                                })
                                ->paginate(10); 

        return view('pages.search', compact('properties'));
    }

}
