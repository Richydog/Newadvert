<?php

namespace App\Http\Controllers\Adverts;

use App\Advert;
use App\Model\Adverts\Category;
use App\Model\Region;
use App\Http\Controllers\Controller;
use App\Http\Requests\Adverts\SearchRequest;
use App\Http\Router\AdvertsPath;
//use App\ReadModel\AdvertReadRepository;
use App\UseCases\Adverts\SearchService;
use App\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AdvertController extends Controller
{/*
    private $search;

    public function __construct(SearchService $search)
    {
        $this->search = $search;
    }

    public function index(SearchRequest $request, AdvertsPath $path)
    {
        $region = $path->region;
        $category = $path->category;

        $result = $this->search->search($category, $region, $request, 20, $request->get('page', 1));

        $adverts = $result->adverts;
        $regionsCounts = $result->regionsCounts;
        $categoriesCounts = $result->categoriesCounts;

        $query = $region ? $region->children() : Region::roots();
        $regions = $query->orderBy('name')->getModels();

        $query = $category ? $category->children() : Category::whereIsRoot();
        $categories = $query->defaultOrder()->getModels();

        $regions = array_filter($regions, function (Region $region) use ($regionsCounts) {
            return isset($regionsCounts[$region->id]) && $regionsCounts[$region->id] > 0;
        });

        $categories = array_filter($categories, function (Category $category) use ($categoriesCounts) {
            return isset($categoriesCounts[$category->id]) && $categoriesCounts[$category->id] > 0;
        });

        return view('adverts.index', compact(
            'category', 'region',
            'categories', 'regions',
            'regionsCounts', 'categoriesCounts',
            'adverts'
        ));
    }

    public function show(Advert $advert)
    {
        if (!($advert->isActive() || Gate::allows('show-advert', $advert))) {
            abort(403);
        }

        $user = Auth::user();

        return view('adverts.show', compact('advert', 'user'));
    }

    public function phone(Advert $advert): string
    {
        if (!($advert->isActive() || Gate::allows('show-advert', $advert))) {
            abort(403);
        }

        return $advert->user->phone;
    }*/

   public function index(Region $region=null,Category $category=null){
       $query=Advert::active()->with(['category','region'])->orderByDesc('id');


       if ($category){
           $query->forCategory($category);
       }
        if ($region){
          $query->forRegion($region);
}
       $query = $region ? $region->children() : Region::roots();
       $regions = $query->orderBy('name')->getModels();

       $query = $category ? $category->children() : Category::whereIsRoot();
       $categories = $query->defaultOrder()->getModels();


       $adverts=$query->paginate(20);

           return view('adverts.admin.index',compact('category','region','adverts'));
   }
   public function show(Advert $advert){

       if (!($advert->isActive() || Gate::allows('show-advert', $advert))) {
           abort(403);
       }

       return view('adverts.show',compact('advert'));
   }

    public function phone(Advert $advert): string
    {
        if (!($advert->isActive() || Gate::allows('show-advert', $advert))) {
            abort(403);
        }

        return $advert->user->phone;
    }
}
