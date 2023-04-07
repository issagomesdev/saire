<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Users
    Route::apiResource('users', 'UsersApiController');

    // Publications
    Route::post('publications/media', 'PublicationsApiController@storeMedia')->name('publications.storeMedia');
    Route::apiResource('publications', 'PublicationsApiController');

    // Categories
    Route::apiResource('categories', 'CategoriesApiController');

    // Gallery
    Route::post('galleries/media', 'GalleryApiController@storeMedia')->name('galleries.storeMedia');
    Route::apiResource('galleries', 'GalleryApiController');
});
