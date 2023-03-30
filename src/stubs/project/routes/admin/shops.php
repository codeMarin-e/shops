<?php

use App\Http\Controllers\Admin\ShopController;
use App\Models\Shop;

Route::group([
    'controller' => ShopController::class,
    'middleware' => ['auth:admin', 'can:view,'.Shop::class],
    'as' => 'shops.', //naming prefix
    'prefix' => 'shops', //for routes
], function() {
    Route::get('', 'index')->name('index');
    Route::post('', 'store')->name('store')->middleware('can:create,'.Shop::class);
    Route::get('create', 'create')->name('create')->middleware('can:create,'.Shop::class);
    Route::get('{chShop}/edit', 'edit')->name('edit');
    Route::get('{chShop}/move/{direction}', "move")->name('move')->middleware('can:update,chShop');

    // @HOOK_ROUTES_MODEL

    Route::get('{chShop}', 'edit')->name('show');
    Route::patch('{chShop}', 'update')->name('update')->middleware('can:update,chShop');
    Route::delete('{chShop}', 'destroy')->name('destroy')->middleware('can:delete,chShop');

    // @HOOK_ROUTES
});
