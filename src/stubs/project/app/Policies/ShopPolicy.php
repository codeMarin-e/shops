<?php

namespace App\Policies;

use App\Models\Shop;
use App\Models\User;

class ShopPolicy
{
    public function before(User $user, $ability) {
        // @HOOK_POLICY_BEFORE
        if($user->hasRole('Super Admin', 'admin') )
            return true;
    }

    public function view(User $user) {
        // @HOOK_POLICY_VIEW
        return $user->hasPermissionTo('shops.view', request()->whereIam());
    }

    public function create(User $user) {
        // @HOOK_POLICY_CREATE
        return $user->hasPermissionTo('shop.create', request()->whereIam());
    }

    public function update(User $user, Shop $chShop) {
        // @HOOK_POLICY_UPDATE
        if( !$user->hasPermissionTo('shop.update', request()->whereIam()) )
            return false;
        return true;
    }

    public function delete(User $user, Shop $chShop) {
        // @HOOK_POLICY_DELETE
        if( !$user->hasPermissionTo('shop.delete', request()->whereIam()) )
            return false;
        return true;
    }

    // @HOOK_POLICY_END


}
