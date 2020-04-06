<?php

use App\Advert;
use App\Model\Adverts\Attribute;
use App\Model\Adverts\Category;
use App\Model\Banner\Banner;
use App\Model\Page;
use App\Model\Region;
//use App\Entity\Ticket\Ticket;
use App\User;
use App\Http\Router\AdvertsPath;
use App\Http\Router\PagePath;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator as Crumbs;
Breadcrumbs::register('start', function (Crumbs $crumbs) {
    $crumbs->push('Start', route('start'));
});
Breadcrumbs::register('home', function (Crumbs $crumbs) {
    $crumbs->push('Home', route('home'));
});

Breadcrumbs::register('login', function (Crumbs $crumbs) {
    $crumbs->parent('home');
    $crumbs->push('Login', route('login'));
});

Breadcrumbs::register('login.phone', function (Crumbs $crumbs) {
    $crumbs->parent('home');
    $crumbs->push('Login', route('login.phone'));
});

Breadcrumbs::register('register', function (Crumbs $crumbs) {
    $crumbs->parent('home');
    $crumbs->push('Register', route('register'));
});

Breadcrumbs::register('password.request', function (Crumbs $crumbs) {
    $crumbs->parent('login');
    $crumbs->push('Reset Password', route('password.request'));
});

Breadcrumbs::register('password.reset', function (Crumbs $crumbs) {
    $crumbs->parent('password.request');
    $crumbs->push('Change', route('password.reset'));
});

Breadcrumbs::register('page', function (Crumbs $crumbs, PagePath $path) {
    if ($parent = $path->page->parent) {
        $crumbs->parent('page', $path->withPage($path->page->parent));
    } else {
        $crumbs->parent('home');
    }
    $crumbs->push($path->page->title, route('page', $path));
});

// Adverts

Breadcrumbs::register('adverts.inner_region', function (Crumbs $crumbs, AdvertsPath $path) {
    if ($path->region && $parent = $path->region->parent) {
        $crumbs->parent('adverts.inner_region', $path->withRegion($parent));
    } else {
        $crumbs->parent('home');
        $crumbs->push('Adverts', route('urad.index'));
    }
    if ($path->region) {
        $crumbs->push($path->region->name, route('urad.index', $path));
    }
});

Breadcrumbs::register('adverts.inner_category', function (Crumbs $crumbs, AdvertsPath $path, AdvertsPath $orig) {
    if ($path->category && $parent = $path->category->parent) {
        $crumbs->parent('adverts.inner_category', $path->withCategory($parent), $orig);
    } else {
        $crumbs->parent('adverts.inner_region', $orig);
    }
    if ($path->category) {
        $crumbs->push($path->category->name, route('urad.index', $path));
    }
});

Breadcrumbs::register('urad.index', function (Crumbs $crumbs, AdvertsPath $path = null) {
    $path = $path ?: adverts_path(null, null);
    $crumbs->parent('adverts.inner_category', $path, $path);
});

Breadcrumbs::register('adverts.show', function (Crumbs $crumbs, Advert $advert) {
    $crumbs->parent('urad.index', adverts_path($advert->region, $advert->category));
    $crumbs->push($advert->title, route('adverts.show', $advert));
});

// Cabinet

Breadcrumbs::register('cabinet.home', function (Crumbs $crumbs) {
    $crumbs->parent('home');
    $crumbs->push('Cabinet', route('home'));
});

Breadcrumbs::register('profilyhome', function (Crumbs $crumbs) {
    $crumbs->parent('home');
    $crumbs->push('Profile', route('profilyhome'));
});

Breadcrumbs::register('profilyedit', function (Crumbs $crumbs) {
    $crumbs->parent('profilyhome');
    $crumbs->push('Edit', route('profilyedit'));
});

Breadcrumbs::register('profilyphone', function (Crumbs $crumbs) {
    $crumbs->parent('profilyhome');
    $crumbs->push('Phone', route('profilyphone'));
});

// Cabinet Adverts

Breadcrumbs::register('index1', function (Crumbs $crumbs) {
    $crumbs->parent('cabinet.home');
    $crumbs->push('Adverts', route('index1'));
});

Breadcrumbs::register('adverts.create', function (Crumbs $crumbs) {
    $crumbs->parent('index1');
    $crumbs->push('Create', route('adverts.create'));
});

Breadcrumbs::register('adverts.create.region', function (Crumbs $crumbs, Category $category, Region $region = null) {
    $crumbs->parent('adverts.create');
    $crumbs->push($category->name, route('adverts.create.region', [$category, $region]));
});

Breadcrumbs::register('adverts.create.advert', function (Crumbs $crumbs, Category $category, Region $region = null) {
    $crumbs->parent('adverts.create.region', $category, $region);
    $crumbs->push($region ? $region->name : 'All', route('adverts.create.advert', [$category, $region]));
});

// Favorites

Breadcrumbs::register('cabinet.favorites.index', function (Crumbs $crumbs) {
    $crumbs->parent('cabinet.home');
    $crumbs->push('Adverts', route('cabinet.favorites.index'));
});

// Cabinet Banners

Breadcrumbs::register('cabinet.banners.index', function (Crumbs $crumbs) {
    $crumbs->parent('cabinet.home');
    $crumbs->push('Banners', route('cabinet.banners.index'));
});

Breadcrumbs::register('cabinet.banners.show', function (Crumbs $crumbs, Banner $banner) {
    $crumbs->parent('cabinet.banners.index');
    $crumbs->push($banner->name, route('cabinet.banners.show', $banner));
});

Breadcrumbs::register('cabinet.banners.edit', function (Crumbs $crumbs, Banner $banner) {
    $crumbs->parent('cabinet.banners.show', $banner);
    $crumbs->push('Edit', route('cabinet.banners.edit', $banner));
});

Breadcrumbs::register('cabinet.banners.file', function (Crumbs $crumbs, Banner $banner) {
    $crumbs->parent('cabinet.banners.show', $banner);
    $crumbs->push('File', route('cabinet.banners.file', $banner));
});

Breadcrumbs::register('cabinet.banners.create', function (Crumbs $crumbs) {
    $crumbs->parent('cabinet.banners.index');
    $crumbs->push('Create', route('cabinet.banners.create'));
});

Breadcrumbs::register('cabinet.banners.create.region', function (Crumbs $crumbs, Category $category, Region $region = null) {
    $crumbs->parent('cabinet.banners.create');
    $crumbs->push($category->name, route('cabinet.banners.create.region', [$category, $region]));
});

Breadcrumbs::register('cabinet.banners.create.banner', function (Crumbs $crumbs, Category $category, Region $region = null) {
    $crumbs->parent('cabinet.banners.create.region', $category, $region);
    $crumbs->push($region ? $region->name : 'All', route('cabinet.banners.create.banner', [$category, $region]));
});

// Cabinet Tickets

Breadcrumbs::register('cabinet.tickets.index', function (Crumbs $crumbs) {
    $crumbs->parent('cabinet.home');
    $crumbs->push('Tickets', route('cabinet.tickets.index'));
});

Breadcrumbs::register('cabinet.tickets.create', function (Crumbs $crumbs) {
    $crumbs->parent('cabinet.tickets.index');
    $crumbs->push('Create', route('cabinet.tickets.create'));
});

Breadcrumbs::register('cabinet.tickets.show', function (Crumbs $crumbs, Ticket $ticket) {
    $crumbs->parent('cabinet.tickets.index');
    $crumbs->push($ticket->subject, route('cabinet.tickets.show', $ticket));
});

// Admin

Breadcrumbs::register('admin.home', function (Crumbs $crumbs) {
    $crumbs->parent('home');
    $crumbs->push('Admin', route('admin.home'));
});

// Users

Breadcrumbs::register('users.index', function (Crumbs $crumbs) {
    $crumbs->parent('admin.home');
    $crumbs->push('Users', route('users.index'));
});

Breadcrumbs::register('users.create', function (Crumbs $crumbs) {
    $crumbs->parent('users.index');
    $crumbs->push('Create', route('users.create'));
});

Breadcrumbs::register('users.show', function (Crumbs $crumbs, User $user) {
    $crumbs->parent('users.index');
    $crumbs->push($user->name, route('users.show', $user));
});

Breadcrumbs::register('users.edit', function (Crumbs $crumbs, User $user) {
    $crumbs->parent('users.show', $user);
    $crumbs->push('Edit', route('users.edit', $user));
});

// Pages

Breadcrumbs::register('admin.pages.index', function (Crumbs $crumbs) {
    $crumbs->parent('admin.home');
    $crumbs->push('Pages', route('admin.pages.index'));
});

Breadcrumbs::register('admin.pages.create', function (Crumbs $crumbs) {
    $crumbs->parent('admin.pages.index');
    $crumbs->push('Create', route('admin.pages.create'));
});

Breadcrumbs::register('admin.pages.show', function (Crumbs $crumbs, Page $page) {
    if ($parent = $page->parent) {
        $crumbs->parent('admin.pages.show', $parent);
    } else {
        $crumbs->parent('admin.pages.index');
    }
    $crumbs->push($page->title, route('admin.pages.show', $page));
});

Breadcrumbs::register('admin.pages.edit', function (Crumbs $crumbs, Page $page) {
    $crumbs->parent('admin.pages.show', $page);
    $crumbs->push('Edit', route('admin.pages.edit', $page));
});

// Banners

Breadcrumbs::register('admin.banners.index', function (Crumbs $crumbs) {
    $crumbs->parent('admin.home');
    $crumbs->push('Banners', route('admin.banners.index'));
});

Breadcrumbs::register('admin.banners.show', function (Crumbs $crumbs, Banner $banner) {
    $crumbs->parent('admin.banners.index');
    $crumbs->push($banner->name, route('admin.banners.show', $banner));
});

Breadcrumbs::register('admin.banners.edit', function (Crumbs $crumbs, Banner $banner) {
    $crumbs->parent('admin.banners.show', $banner);
    $crumbs->push('Edit', route('admin.banners.edit', $banner));
});

Breadcrumbs::register('admin.banners.reject', function (Crumbs $crumbs, Banner $banner) {
    $crumbs->parent('admin.banners.show', $banner);
    $crumbs->push('Reject', route('admin.banners.reject', $banner));
});

// Tickets

Breadcrumbs::register('admin.tickets.index', function (Crumbs $crumbs) {
    $crumbs->parent('admin.home');
    $crumbs->push('Tickets', route('admin.tickets.index'));
});

Breadcrumbs::register('admin.tickets.show', function (Crumbs $crumbs, Ticket $ticket) {
    $crumbs->parent('admin.tickets.index');
    $crumbs->push($ticket->subject, route('admin.tickets.show', $ticket));
});

Breadcrumbs::register('admin.tickets.edit', function (Crumbs $crumbs, Ticket $ticket) {
    $crumbs->parent('admin.tickets.show', $ticket);
    $crumbs->push('Edit', route('admin.tickets.edit', $ticket));
});

// Regions

Breadcrumbs::register('regions.index', function (Crumbs $crumbs) {
    $crumbs->parent('admin.home');
    $crumbs->push('Regions', route('regions.index'));
});

Breadcrumbs::register('regions.create', function (Crumbs $crumbs) {
    $crumbs->parent('regions.index');
    $crumbs->push('Create', route('regions.create'));
});

Breadcrumbs::register('regions.show', function (Crumbs $crumbs, Region $region) {
    if ($parent = $region->parent) {
        $crumbs->parent('regions.show', $parent);
    } else {
        $crumbs->parent('regions.index');
    }
    $crumbs->push($region->name, route('regions.show', $region));
});

Breadcrumbs::register('regions.edit', function (Crumbs $crumbs, Region $region) {
    $crumbs->parent('regions.show', $region);
    $crumbs->push('Edit', route('regions.edit', $region));
});

// Adverts

Breadcrumbs::register('admin/adverts.admin.index', function (Crumbs $crumbs) {
    $crumbs->parent('admin.home');
    $crumbs->push('Categories', route('admin/adverts.admin.index'));
});

Breadcrumbs::register('admin/adverts.admin.edit', function (Crumbs $crumbs, Advert $advert) {
    $crumbs->parent('admin.home');
    $crumbs->push($advert->title, route('admin/adverts.admin.edit', $advert));
});

Breadcrumbs::register('admin.adverts.adverts.reject', function (Crumbs $crumbs, Advert $advert) {
    $crumbs->parent('admin.home');
    $crumbs->push($advert->title, route('admin.adverts.adverts.reject', $advert));
});

// Advert Categories

Breadcrumbs::register('categories.index', function (Crumbs $crumbs) {
    $crumbs->parent('admin.home');
    $crumbs->push('Categories', route('categories.index'));
});

Breadcrumbs::register('categories.create', function (Crumbs $crumbs) {
    $crumbs->parent('categories.index');
    $crumbs->push('Create', route('categories.create'));
});

Breadcrumbs::register('categories.show', function (Crumbs $crumbs, Category $category) {
    if ($parent = $category->parent) {
        $crumbs->parent('categories.show', $parent);
    } else {
        $crumbs->parent('categories.index');
    }
    $crumbs->push($category->name, route('categories.show', $category));
});

Breadcrumbs::register('categories.edit', function (Crumbs $crumbs, Category $category) {
    $crumbs->parent('categories.show', $category);
    $crumbs->push('Edit', route('categories.edit', $category));
});

// Advert Category Attributes

Breadcrumbs::register('categories.attributes.create', function (Crumbs $crumbs, Category $category) {
    $crumbs->parent('categories.show', $category);
    $crumbs->push('Create', route('categories.attributes.create', $category));
});

Breadcrumbs::register('categories.attributes.show', function (Crumbs $crumbs, Category $category, Attribute $attribute) {
    $crumbs->parent('categories.show', $category);
    $crumbs->push($attribute->name, route('categories.attributes.show', [$category, $attribute]));
});

Breadcrumbs::register('categories.attributes.edit', function (Crumbs $crumbs, Category $category, Attribute $attribute) {
    $crumbs->parent('categories.attributes.show', $category, $attribute);
    $crumbs->push('Edit', route('categories.attributes.edit', [$category, $attribute]));
});
