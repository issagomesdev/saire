<?php

//Route::redirect('/', '/login');

Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});


Route::get('/', 'SitesController@index')->name('site.index');
Route::get('/galeria', 'SitesController@galleries')->name('site.gallery');
Route::get('/noticias', 'SitesController@publications')->name('site.publications');
Route::get('/noticias/{title}', 'SitesController@show')->name('site.publications.show');
Route::get('/pagina/{title}', 'SitesController@page')->name('site.page');

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Publications
    Route::delete('publications/destroy', 'PublicationsController@massDestroy')->name('publications.massDestroy');
    Route::post('publications/media', 'PublicationsController@storeMedia')->name('publications.storeMedia');
    Route::post('publications/ckmedia', 'PublicationsController@storeCKEditorImages')->name('publications.storeCKEditorImages');
    Route::get('favpublications', 'PublicationsController@favPublications')->name('publications.favpublications');
    Route::resource('publications', 'PublicationsController');

    // Categories
    Route::delete('categories/destroy', 'CategoriesController@massDestroy')->name('categories.massDestroy');
    Route::resource('categories', 'CategoriesController');

    // Gallery
    Route::delete('galleries/destroy', 'GalleryController@massDestroy')->name('galleries.massDestroy');
    Route::post('galleries/media', 'GalleryController@storeMedia')->name('galleries.storeMedia');
    Route::post('galleries/ckmedia', 'GalleryController@storeCKEditorImages')->name('galleries.storeCKEditorImages');
    Route::resource('galleries', 'GalleryController');

    // Audit Logs
    Route::resource('audit-logs', 'AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);
    
    // Menus
    Route::delete('menus/destroy', 'MenusController@massDestroy')->name('menus.massDestroy');
    Route::post('menus/reorder', 'MenusController@reorder')->name('menus.reorder');
    Route::resource('menus', 'MenusController');

    // Submenu
    Route::delete('submenus/destroy', 'SubmenuController@massDestroy')->name('submenus.massDestroy');
    Route::post('submenus/reorder', 'SubmenuController@reorder')->name('submenus.reorder');
    Route::resource('submenus', 'SubmenuController');

    // Page
    Route::delete('pages/destroy', 'PageController@massDestroy')->name('pages.massDestroy');
    Route::post('pages/media', 'PageController@storeMedia')->name('pages.storeMedia');
    Route::post('pages/ckmedia', 'PageController@storeCKEditorImages')->name('pages.storeCKEditorImages');
    Route::resource('pages', 'PageController');
});

Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
