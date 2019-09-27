<?php

namespace App\Http\Controllers;

use App\Advert;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use App\Model\Region;
use  App\Model\Adverts\Category;
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

        //$this->middleware(['auth'=>'verified']);
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
    $adverts=Advert::all();
        return view('home', compact('regions', 'categories','adverts'));

    }
}
