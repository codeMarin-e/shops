<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\OpenCloseRequest;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\ShopRequest;
use App\Models\Shop;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;


class ShopController extends Controller {
    public function __construct() {
        if(!request()->route()) return;

        $this->db_table = Shop::getModel()->getTable();
        $this->routeNamespace = Str::before(request()->route()->getName(), '.shops');
        View::composer('admin/shops/*', function($view)  {
            $viewData = [
                'route_namespace' => $this->routeNamespace,
            ];
            // @HOOK_VIEW_COMPOSERS
            $view->with($viewData);
        });
        // @HOOK_CONSTRUCT
    }

    public function index() {
        $viewData = [];
        $viewData['shops'] =  Shop::where("{$this->db_table}.site_id", app()->make('Site')->id)->orderBy("{$this->db_table}.ord", 'ASC');

        // @HOOK_INDEX_END

        $viewData['shops'] = $viewData['shops']->paginate(20)->appends( request()->query() );

        return view('admin/shops/shops', $viewData);
    }

    public function create() {
        $viewData = [];

        // @HOOK_CREATE

        return view('admin/shops/shop', $viewData);
    }

    public function edit(Shop $chShop) {
        $viewData = [];

        // @HOOK_EDIT

        $viewData['chShop'] = $chShop;
        return view('admin/shops/shop', $viewData);
    }

    public function store(ShopRequest $request) {
        $validatedData = $request->validated();

        // @HOOK_STORE_VALIDATE

        $chShop = Shop::create( array_merge([
            'site_id' => app()->make('Site')->id,
        ], $validatedData));

        // @HOOK_STORE_INSTANCE

        $chShop->setAVars($validatedData['add']);
        OpenCloseRequest::submit($chShop, $validatedData);

        // @HOOK_STORE_END
        event( 'shop.submited', [$chShop, $validatedData] );

        return redirect()->route($this->routeNamespace.'.shops.edit', $chShop)
            ->with('message_success', trans('admin/shops/shop.created'));
    }

    public function update(Shop $chShop, ShopRequest $request) {
        $validatedData = $request->validated();

        // @HOOK_UPDATE_VALIDATE

        $chShop->update( $validatedData );
        $chShop->setAVars($validatedData['add']);
        OpenCloseRequest::submit($chShop, $validatedData);

        // @HOOK_UPDATE_END

        event( 'shop.submited', [$chShop, $validatedData] );
        if($request->has('action')) {
            return redirect()->route($this->routeNamespace.'.shops.index')
                ->with('message_success', trans('admin/shops/shop.updated'));
        }
        return back()->with('message_success', trans('admin/shops/shop.updated'));
    }

    public function move(Shop $chShop, $direction) {
        // @HOOK_MOVE

        $chShop->orderMove($direction);

        // @HOOK_MOVE_END

        return back();
    }

    public function destroy(Shop $chShop, Request $request) {

        // @HOOK_DESTROY

        $chShop->delete();

        // @HOOK_DESTROY_END

        event( 'shop.removed', [$chShop] );

        if($request->redirect_to)
            return redirect()->to($request->redirect_to)
                ->with('message_danger', trans('admin/shops/shop.deleted'));

        return redirect()->route($this->routeNamespace.'.shops.index')
            ->with('message_danger', trans('admin/shops/shop.deleted'));
    }
}
