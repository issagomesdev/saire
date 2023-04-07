<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use App\Http\Resources\Admin\MenuResource;
use App\Models\Menu;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MenusApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('menu_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new MenuResource(Menu::with(['submenuses', 'page'])->get());
    }

    public function store(StoreMenuRequest $request)
    {
        $menu = Menu::create($request->all());
        $menu->submenuses()->sync($request->input('submenuses', []));

        return (new MenuResource($menu))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Menu $menu)
    {
        abort_if(Gate::denies('menu_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new MenuResource($menu->load(['submenuses', 'page']));
    }

    public function update(UpdateMenuRequest $request, Menu $menu)
    {
        $menu->update($request->all());
        $menu->submenuses()->sync($request->input('submenuses', []));

        return (new MenuResource($menu))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Menu $menu)
    {
        abort_if(Gate::denies('menu_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $menu->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
