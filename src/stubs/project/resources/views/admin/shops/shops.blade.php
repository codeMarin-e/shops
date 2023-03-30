<x-admin.main>
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route("{$route_namespace}.home")}}"><i class="fa fa-home"></i></a></li>
            <li class="breadcrumb-item active">@lang('admin/shops/shops.shops')</li>
        </ol>

        @can('create', App\Models\Shop::class)
            <a href="{{ route("{$route_namespace}.shops.create") }}"
               class="btn btn-sm btn-primary h5"
               title="create">
                <i class="fa fa-plus mr-1"></i>@lang('admin/shops/shops.create')
            </a>
        @endcan

        {{-- @HOOK_AFTER_CREATE --}}

        <x-admin.box_messages />

        <div class="table-responsive rounded ">
            <table class="table table-sm">
                <thead class="thead-light">
                <tr class="">
                    <th scope="col" class="text-center">@lang('admin/shops/shops.id')</th>
                    {{-- @HOOK_AFTER_ID_TH --}}

                    <th scope="col" class="w-75">@lang('admin/shops/shops.name')</th>
                    {{-- @HOOK_AFTER_NAME_TH --}}

                    <th scope="col" class="text-center">@lang('admin/shops/shops.edit')</th>
                    {{-- @HOOK_AFTER_EDIT_TH --}}

                    <th colspan="2" scope="col" class="text-center">@lang('admin/shops/shops.move_th')</th>
                    {{-- @HOOK_AFTER_MOVE_TH --}}

                    <th scope="col" class="text-center">@lang('admin/shops/shops.remove')</th>
                    {{-- @HOOK_AFTER_REMOVE_TH --}}
                </tr>
                </thead>
                <tbody>
                @forelse($shops as $shop)
                    @php
                        $shopEditUri = route("{$route_namespace}.shops.edit", $shop->id);
                        $canUpdate = $authUser->can('update', $shop);
                    @endphp
                    @if($loop->first)
                        @php $prevDelivery = $shop->getPrevious(); @endphp
                    @endif
                    @if($loop->last)
                        @php $nextDelivery = $shop->getNext(); @endphp
                    @endif
                    <tr data-id="{{$shop->id}}"
                        data-parent="{{$shop->parent_id}}"
                        data-show="1">
                        <td scope="row" class="text-center align-middle"><a href="{{ $shopEditUri }}"
                                                                            title="@lang('admin/shops/shops.edit')"
                            >{{ $shop->id }}</a></td>
                        {{-- @HOOK_AFTER_ID --}}

                        {{--    REAL NAME    --}}
                        <td class="w-75 align-middle">
                            <a href="{{ $shopEditUri }}"
                               title="@lang('admin/shops/shops.edit')"
                               class="@if($shop->active) @else text-danger @endif"
                            >{{ \Illuminate\Support\Str::words($shop->aVar('name'), 12,'....') }}</a>
                            @if($shop->default)<span class="badge badge-success">@lang('admin/shops/shops.default')</span>@endif
                            @if($shop->test_mode)<span class="badge badge-warning">@lang('admin/shops/shops.test_mode')</span>@endif
                        </td>
                        {{-- @HOOK_AFTER_NAME --}}

                        {{--    EDIT    --}}
                        <td class="text-center">
                            <a class="btn btn-link text-success"
                               href="{{ $shopEditUri }}"
                               title="@lang('admin/shops/shops.edit')"><i class="fa fa-edit"></i></a></td>
                        {{-- @HOOK_AFTER_EDIT--}}

                        {{--    MOVE DOWN    --}}
                        <td class="text-center">
                            @if($canUpdate && (!$loop->last || $nextDelivery))
                                <a class="btn btn-link"
                                   href="{{route("{$route_namespace}.shops.move", [$shop, 'down'])}}"
                                   title="@lang('admin/shops/shops.move_down')"><i class="fa fa-arrow-down"></i></a>
                            @endif
                        </td>

                        {{--    MOVE UP   --}}
                        <td class="text-center">
                            @if($canUpdate && (!$loop->first || $prevDelivery))
                                <a class="btn btn-link"
                                   href="{{route("{$route_namespace}.shops.move", [$shop,'up'])}}"
                                   title="@lang('admin/shops/shops.move_up')"><i class="fa fa-arrow-up"></i></a>
                            @endif
                        </td>
                        {{-- @HOOK_AFTER_MOVE--}}

                        {{--    DELETE    --}}
                        <td class="text-center">
                            @can('delete', $shop)
                                <form action="{{ route("{$route_namespace}.shops.destroy", $shop->id) }}"
                                      method="POST"
                                      id="delete[{{$shop->id}}]">
                                    @csrf
                                    @method('DELETE')
                                    @php
                                        $redirectTo = (!$shops->onFirstPage() && $shops->count() == 1)?
                                                $shops->previousPageUrl() :
                                                url()->full();
                                    @endphp
                                    <button class="btn btn-link text-danger"
                                            title="@lang('admin/shops/shops.remove')"
                                            onclick="if(confirm('@lang("admin/shops/shops.remove_ask")')) document.querySelector( '#delete\\[{{$shop->id}}\\] ').submit() "
                                            type="button"><i class="fa fa-trash"></i></button>
                                </form>
                            @endcan
                        </td>
                        {{-- @HOOK_AFTER_REMOVE --}}
                    </tr>
                @empty
                    <tr>
                        <td colspan="100%">@lang('admin/shops/shops.no_shops')</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            {{$shops->links('admin.paging')}}

        </div>
    </div>
</x-admin.main>
