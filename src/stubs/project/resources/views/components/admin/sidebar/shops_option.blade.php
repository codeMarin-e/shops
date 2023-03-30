@if($authUser->can('view', \App\Models\Shop::class))
    {{-- SHOPS --}}
    <li class="nav-item @if(request()->route()->named("{$whereIam}.shops.*")) active @endif">
        <a class="nav-link " href="{{route("{$whereIam}.shops.index")}}">
            <i class="fa fa-fw fa-store-alt mr-1"></i>
            <span>@lang("admin/shops/shops.sidebar")</span>
        </a>
    </li>
@endif
