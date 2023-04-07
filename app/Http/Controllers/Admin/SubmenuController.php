<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySubmenuRequest;
use App\Http\Requests\StoreSubmenuRequest;
use App\Http\Requests\UpdateSubmenuRequest;
use App\Models\Page;
use App\Models\Submenu;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SubmenuController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('submenu_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Submenu::with(['page'])->select(sprintf('%s.*', (new Submenu)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'submenu_show';
                $editGate      = 'submenu_edit';
                $deleteGate    = 'submenu_delete';
                $crudRoutePart = 'submenus';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('title', function ($row) {
                return $row->title ? $row->title : '';
            });
            $table->editColumn('link_type', function ($row) {
                return Submenu::LINK_TYPE_RADIO[$row->link_type];
            });
            $table->addColumn('page_title', function ($row) {
                return $row->page ? $row->page->title : '';
            });

            $table->editColumn('url', function ($row) {
                return $row->url ? $row->url : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'page']);

            return $table->make(true);
        }

        $pages = Page::get();

        return view('admin.submenus.index', compact('pages'));
    }

    public function reorder(Request $request)
    {
            Submenu::find($request->id)->update([
                'position' => $request->position
            ]);

        return redirect()->route('admin.submenus.index');
    }

    public function create()
    {
        abort_if(Gate::denies('submenu_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pages = Page::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.submenus.create', compact('pages'));
    }

    public function store(StoreSubmenuRequest $request)
    {
        $submenu = Submenu::create($request->all());

        return redirect()->route('admin.submenus.index');
    }

    public function edit(Submenu $submenu)
    {
        abort_if(Gate::denies('submenu_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pages = Page::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $submenu->load('page');

        return view('admin.submenus.edit', compact('pages', 'submenu'));
    }

    public function update(UpdateSubmenuRequest $request, Submenu $submenu)
    {
        $submenu->update($request->all());

        return redirect()->route('admin.submenus.index');
    }

    public function show(Submenu $submenu)
    {
        abort_if(Gate::denies('submenu_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $submenu->load('page');

        return view('admin.submenus.show', compact('submenu'));
    }

    public function destroy(Submenu $submenu)
    {
        abort_if(Gate::denies('submenu_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $submenu->delete();

        return back();
    }

    public function massDestroy(MassDestroySubmenuRequest $request)
    {
        $submenus = Submenu::find(request('ids'));

        foreach ($submenus as $submenu) {
            $submenu->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
