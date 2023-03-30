<?php

use App\Models\Shop;
use App\Policies\ShopPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

Route::model('chShop', Shop::class);
Gate::policy(Shop::class, ShopPolicy::class);

