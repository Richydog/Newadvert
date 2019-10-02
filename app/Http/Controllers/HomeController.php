<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Advert;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use App\Model\Region;
use  App\Model\Adverts\Category;
use App\Http\Router\AdvertsPath;
use Illuminate\Support\Facades\Gate;
class
HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       $this->middleware('auth');
        /**
         *
         *ниже верификация с электронной почтой
         *
         */

       // $this->middleware(['auth'=>'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $regions = Region::roots()->orderBy('name')->getModels();

        $categories = Category::whereIsRoot()->defaultOrder()->getModels();
    $adverts=Advert::get()->where(Auth::user());
        return view('home', compact('regions', 'categories','adverts'));

    }


}




