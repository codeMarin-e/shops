@php $inputBag = 'shop'; @endphp

@pushonce('below_templates')
@if(isset($chShop) && $authUser->can('delete', $chShop))
    <form action="{{ route("{$route_namespace}.shops.destroy", $chShop->id) }}"
          method="POST"
          id="delete[{{$chShop->id}}]">
        @csrf
        @method('DELETE')
    </form>
@endif
@endpushonce

<x-admin.main>
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route("{$route_namespace}.home")}}"><i class="fa fa-home"></i></a>
            </li>
            <li class="breadcrumb-item"><a
                    href="{{ route("{$route_namespace}.shops.index") }}">@lang('admin/shops/shops.shops')</a>
            </li>
            <li class="breadcrumb-item active">@isset($chShop){{ $chShop->aVar('name') }}@else @lang('admin/shops/shop.create') @endisset</li>
        </ol>

        <div class="card">
            <div class="card-body">
                <form
                    action="@isset($chShop){{ route("{$route_namespace}.shops.update", [ $chShop->id ]) }}@else{{ route("{$route_namespace}.shops.store") }}@endisset"
                    method="POST"
                    autocomplete="off"
                    enctype="multipart/form-data">
                    @csrf
                    @isset($chShop)@method('PATCH')@endisset

                    <x-admin.box_messages />

                    <x-admin.box_errors :inputBag="$inputBag" />
                    {{-- @HOOK_BEGINING --}}

                    <div class="form-group row">
                        <label for="{{$inputBag}}[name]"
                               class="col-lg-2 col-form-label"
                        >@lang('admin/shops/shop.name'):</label>
                        <div class="col-lg-10">
                            <input type="text"
                                   name="{{$inputBag}}[add][name]"
                                   id="{{$inputBag}}[add][name]"
                                   value="{{ old("{$inputBag}.add.name", (isset($chShop)? $chShop->aVar('name') : '')) }}"
                                   class="form-control @if($errors->$inputBag->has('add.name')) is-invalid @endif"
                            />
                        </div>
                    </div>
                    {{-- @HOOK_AFTER_NAME --}}

                    <div class="form-group row">
                        <label for="{{$inputBag}}[add][description]"
                               class="col-lg-2 col-form-label @if($errors->$inputBag->has('add.description')) text-danger @endif"
                        >@lang('admin/shops/shop.description'):</label>
                        <div class="col-lg-10">
                            <x-admin.editor
                                :inputName="$inputBag.'[add][description]'"
                                :otherClasses="[ 'form-controll', ]"
                            >{{old("{$inputBag}.add.description", (isset($chShop)? $chShop->aVar('description') : ''))}}</x-admin.editor>
                        </div>
                    </div>
                    {{-- @HOOK_AFTER_DESCRIPTION --}}

                    <x-admin.open_close
                        :inputBag="$inputBag"
                        :openCloseable="$chShop?? null"
                    />
                    {{-- @HOOK_OPEN_CLOSE --}}

                    <div class="form-group row form-check">
                        <div class="col-lg-6">
                            <input type="checkbox"
                                   value="1"
                                   id="{{$inputBag}}[active]"
                                   name="{{$inputBag}}[active]"
                                   class="form-check-input @if($errors->$inputBag->has('active'))is-invalid @endif"
                                   @if(old("{$inputBag}.active") || (is_null(old("{$inputBag}.active")) && isset($chShop) && $chShop->active ))checked="checked"@endif
                            />
                            <label class="form-check-label"
                                   for="{{$inputBag}}[active]">@lang('admin/shops/shop.active')</label>
                        </div>
                    </div>
                    {{-- @HOOK_AFTER_ACTIVE --}}

                    <div class="form-group row">
                        @isset($chShop)
                            @can('update', $chShop)
                                <button class='btn btn-success mr-2'
                                        type='submit'
                                        name='action'>@lang('admin/shops/shop.save')
                                </button>

                                <button class='btn btn-primary mr-2'
                                        type='submit'
                                        name='update'>@lang('admin/shops/shop.update')</button>
                            @endcan

                            @can('delete', $chShop)
                                <button class='btn btn-danger mr-2'
                                        type='button'
                                        onclick="if(confirm('@lang("admin/shops/shop.delete_ask")')) document.querySelector( '#delete\\[{{$chShop->id}}\\] ').submit() "
                                        name='delete'>@lang('admin/shops/shop.delete')</button>
                            @endcan
                        @else
                            @can('create', App\Models\Shop::class)
                                <button class='btn btn-success mr-2'
                                        type='submit'
                                        name='create'>@lang('admin/shops/shop.create')</button>
                            @endcan
                        @endisset

                        {{-- @HOOK_AFTER_BUTTONS --}}

                        <a class='btn btn-warning'
                           href="{{ route("{$route_namespace}.shops.index") }}"
                        >@lang('admin/shops/shop.cancel')</a>
                    </div>

                    {{-- @HOOK_ADDON_BUTTONS --}}
                </form>
            </div>
        </div>
    </div>
</x-admin.main>
