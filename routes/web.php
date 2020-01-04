<?php
use \Illuminate\Support\Facades\Route;
use \Illuminate\Support\Facades\Auth;
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

/*Route::get('/', function () {
    return view('welcome');
});

*/

Auth::routes(['verify'=>true]);

Route::get('profile', function () {

})->middleware('verified');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/banner/get', 'BannerController@get')->name('banner.get');
Route::get('/banner/{banner}/click', 'BannerController@click')->name('banner.click');

Route::resource('/adverts','Cabinet\AdvertsController');



Route::group(['prefix' => 'profily', 'as' => 'profily','middleware'=>['auth']], function () {
    Route::get('/', 'Cabinet\ProfileController@index')->name('home');
    Route::get('/edit', 'Cabinet\ProfileController@edit')->name('edit');
    Route::put('/update', 'Cabinet\ProfileController@update')->name('update');
    Route::post('/phone', 'Cabinet\PhoneController@request');
    Route::get('/phone', 'Cabinet\PhoneController@form')->name('phone');
    Route::put('/phone', 'Cabinet\PhoneController@verify')->name('phone.verify');
 });


Route::group([
    'prefix' => 'adverts',
    'as' => 'adverts.',
    'namespace' => 'Adverts',
], function () {
    Route::get('/show/{advert}', 'AdvertController@show')->name('show');
    Route::post('/show/{advert}/phone', 'AdvertController@phone')->name('phone');
  //  Route::get('/all/{category?}', 'AdvertController@index')->name('index.all');
   // Route::get('/{region?}/{category}', 'AdvertController@index')->name('index');
    Route::post('/show/{advert}/favorites', 'FavoriteController@add')->name('favorites');
    Route::delete('/show/{advert}/favorites', 'FavoriteController@remove');


});



Route::middleware('auth','can:admin-panel')->group(
     function () {

   Route::get('/admin','Admin\HomeController@index')->name('admin.home');

   Route::resource('/admin/users','Admin\UserController');
         Route::post('/admin/users/show','Admin\UserController@');
         Route::resource('/admin/regions','Admin\RegionController');
         Route::resource('/admin/adverts/categories','Admin\Adverts\CategoryController');

         Route::group(['prefix' => 'categories/{category}', 'as' => 'categories.'], function () {
             Route::post('/admin/adverts/categories/first', 'Admin\Adverts\CategoryController@first')->name('first');
             Route::post('/admin/adverts/categories/up', 'Admin\Adverts\CategoryController@up')->name('up');
             Route::post('/admin/adverts/categories/down', 'Admin\Adverts\CategoryController@down')->name('down');
             Route::post('/admin/adverts/categories/last', 'Admin\Adverts\CategoryController@last')->name('last');
             Route::resource('attributes', 'Admin\Adverts\AttributeController')->except('index');
         });
});
//Route::get('/adverts', 'Adverts\AdvertController@index')->name('index');
Route::get('/cabadvert', 'Cabinet\AdvertsController@index')->name('index1');
//Route::get('/adverts', 'Cabinet\AdvertsController@create');
Route::group([
    'prefix' => 'adverts',
    'as' => 'adverts.',
    'namespace' => 'Cabinet',
    'middleware' => ['dopusk'],
], function () {

    Route::get('/create', 'CreateController@category')->name('create');
    Route::get('/create/region/{category}/{region?}', 'CreateController@region')->name('create.region');
    Route::get('/create/advert/{category}/{region?}', 'CreateController@advert')->name('create.advert');
    Route::post('/create/advert/{category}/{region?}', 'CreateController@store')->name('create.advert.store');

    Route::get('/{advert}/edit', 'ManageController@editForm')->name('man.edit');
    Route::put('/{advert}/edit', 'ManageController@edit');
    Route::get('/{advert}/photos', 'ManageController@photosForm')->name('man.photos');
    Route::post('/{advert}/photos', 'ManageController@photos');
    Route::get('/{advert}/attributes', 'ManageController@attributesForm')->name('man.attributes');
    Route::post('/{advert}/attributes', 'ManageController@attributes');
    Route::post('/{advert}/send', 'ManageController@send')->name('man.send');
    Route::post('/{advert}/close', 'ManageController@close')->name('man.close');
    Route::delete('/{advert}/destroy', 'ManageController@destroy')->name('man.destroy');
});

Route::group(['prefix' => 'admin/adverts', 'as' => 'admin/adverts.', 'namespace' => 'Admin\Adverts'], function () {
    Route::get('/', 'AdvertController@index')->name('admin.index');
    Route::get('/{advert}/edit', 'AdvertController@editForm')->name('admin.edit');
    Route::put('/{advert}/edit', 'AdvertController@edit');
    Route::get('/{advert}/photos', 'AdvertController@photosForm')->name('admin.photos');
    Route::post('/{advert}/photos', 'AdvertController@photos');
    Route::get('/{advert}/attributes', 'AdvertController@attributesForm')->name('admin.attributes');
    Route::post('/{advert}/attributes', 'AdvertController@attributes');
    Route::post('/{advert}/moderate', 'AdvertController@moderate')->name('admin.moderate');
    Route::get('/{advert}/reject', 'AdvertController@rejectForm')->name('admin.reject');
    Route::post('/{advert}/reject', 'AdvertController@reject');
    Route::delete('/{advert}/destroy', 'AdvertController@destroy')->name('admin.destroy');
});
//Route::get('/cabadverts', 'Admin\Adverts\AdvertController@index')->name('admin.index');
Route::group(
    [
        'prefix' => 'cabinet',
        'as' => 'cabinet.',
        'namespace' => 'Cabinet',
        'middleware' => ['auth'],
    ],
    function () {
        Route::get('favorites', 'FavoriteController@index')->name('favorites.index');
        Route::delete('favorites/{advert}', 'FavoriteController@remove')->name('favorites.remove');
    });

Route::group(
    [
        'prefix' => 'admin',
        'as' => 'admin.',
        'namespace' => 'Admin',
        'middleware' => ['auth', 'can:admin-panel'],
    ],
    function () {

        Route::group(['prefix' => 'banners', 'as' => 'banners.'], function () {
            Route::get('/', 'BannerController@index')->name('index');
            Route::get('/{banner}/show', 'BannerController@show')->name('show');
            Route::get('/{banner}/edit', 'BannerController@editForm')->name('edit');
            Route::put('/{banner}/edit', 'BannerController@edit');
            Route::post('/{banner}/moderate', 'BannerController@moderate')->name('moderate');
            Route::get('/{banner}/reject', 'BannerController@rejectForm')->name('reject');
            Route::post('/{banner}/reject', 'BannerController@reject');
            Route::post('/{banner}/pay', 'BannerController@pay')->name('pay');
            Route::delete('/{banner}/destroy', 'BannerController@destroy')->name('destroy');
        });
    }
);

Route::group(
    [
        'prefix' => 'cabinet',
        'as' => 'cabinet.',
        'namespace' => 'Cabinet',
        'middleware' => ['auth'],
    ],
    function () {
        Route::group([
            'prefix' => 'banners',
            'as' => 'banners.',
            'namespace' => 'Banners',
            'middleware' => [App\Http\Middleware\FilledProfile::class],
        ], function () {
            Route::get('/', 'BannerController@index')->name('index');
            Route::get('/create', 'CreateController@category')->name('create');
            Route::get('/create/region/{category}/{region?}', 'CreateController@region')->name('create.region');
            Route::get('/create/banner/{category}/{region?}', 'CreateController@banner')->name('create.banner');
            Route::post('/create/banner/{category}/{region?}', 'CreateController@store')->name('create.banner.store');

            Route::get('/show/{banner}', 'BannerController@show')->name('show');
            Route::get('/{banner}/edit', 'BannerController@editForm')->name('edit');
            Route::put('/{banner}/edit', 'BannerController@edit');
            Route::get('/{banner}/file', 'BannerController@fileForm')->name('file');
            Route::put('/{banner}/file', 'BannerController@file');
            Route::post('/{banner}/send', 'BannerController@send')->name('send');
            Route::post('/{banner}/cancel', 'BannerController@cancel')->name('cancel');
            Route::post('/{banner}/order', 'BannerController@order')->name('order');
            Route::delete('/{banner}/destroy', 'BannerController@destroy')->name('destroy');
        });
    }
);

Route::get('/{adverts_path?}', 'Adverts\AdvertController@index')->name('index')->where(!'create', 'adverts_path', '.+');

Route::get('/', 'StartController@index')->name('start');
