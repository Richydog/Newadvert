<?php

namespace App\Http\Controllers\Cabinet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Adverts\Category;
use App\Model\Region;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Adverts\CreateRequest;
use App\UseCases\Adverts\AdvertService;
class CreateController extends Controller
{  private $service;

    public function __construct(AdvertService $service)
    {
        $this->service = $service;
    }




    public function category()
    {
        $categories = Category::defaultOrder()->withDepth()->get()->toTree();

        return view('cabinet.adverts.create.category', compact('categories'));
    }

    public function region(Category $category, Region $region = null)
    {
        $regions = Region::where('parent_id', $region ? $region->id : null)->orderBy('name')->get();

        return view('cabinet.adverts.create.region', compact('category', 'region', 'regions'));
    }

    public function advert(Category $category, Region $region = null)
    {
        return view('cabinet.adverts.create.advert', compact('category', 'region'));
    }

    public function store(CreateRequest $request, Category $category, Region $region = null)
    {
        try {
            $advert = $this->service->create(
                Auth::id(),
                $category->id,
                $region ? $region->id : null,
                $request
            );
        } catch (\DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('adverts.show', $advert);
    }
}
