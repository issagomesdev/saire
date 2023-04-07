<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubmenuRequest;
use App\Http\Requests\UpdateSubmenuRequest;
use App\Http\Resources\Admin\SubmenuResource;
use App\Models\Submenu;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubmenuApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('submenu_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SubmenuResource(Submenu::with(['page'])->get());
    }

    public function store(StoreSubmenuRequest $request)
    {
        $submenu = Submenu::create($request->all());

        return (new SubmenuResource($submenu))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Submenu $submenu)
    {
        abort_if(Gate::denies('submenu_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SubmenuResource($submenu->load(['page']));
    }

    public function update(UpdateSubmenuRequest $request, Submenu $submenu)
    {
        $submenu->update($request->all());

        return (new SubmenuResource($submenu))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Submenu $submenu)
    {
        abort_if(Gate::denies('submenu_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $submenu->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
