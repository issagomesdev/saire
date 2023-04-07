<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyMenuRequest;
use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use App\Models\Menu;
use App\Models\Page;
use App\Models\Submenu;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class MenusController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('menu_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Menu::with(['submenuses', 'page'])->select(sprintf('%s.*', (new Menu)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');
            $table->addColumn('position', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'menu_show';
                $editGate      = 'menu_edit';
                $deleteGate    = 'menu_delete';
                $crudRoutePart = 'menus';

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
            $table->editColumn('position', function ($row) {
                return $row->position;
            });
            $table->editColumn('link_type', function ($row) {
                return Menu::LINK_TYPE_RADIO[$row->link_type];
            });

            $table->rawColumns(['actions', 'placeholder', 'position']);

            return $table->make(true);
        }

        $submenus = Submenu::get();
        $pages    = Page::get();

        return view('admin.menus.index', compact('submenus', 'pages'));
    }

    public function reorder(Request $request)
    {
            Menu::find($request->id)->update([
                'position' => $request->position
            ]);

            return redirect()->route('admin.menus.index');
    }

    public function create()
    {
        abort_if(Gate::denies('menu_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $submenuses = Submenu::pluck('title', 'id');

        $pages = Page::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $count_menus = Menu::count() + 1;

        return view('admin.menus.create', compact('pages', 'submenuses', 'count_menus'));
    }

    public function store(StoreMenuRequest $request)
    {  
        $menu = Menu::create($request->all());
        $menu->submenuses()->sync($request->input('submenuses', []));

        return redirect()->route('admin.menus.index');
    }

    public function edit(Menu $menu)
    {
        abort_if(Gate::denies('menu_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $submenuses = Submenu::pluck('title', 'id');

        $pages = Page::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $menu->load('submenuses', 'page');

        return view('admin.menus.edit', compact('menu', 'pages', 'submenuses'));
    }

    public function update(UpdateMenuRequest $request, Menu $menu)
    {
        $menu->update($request->all());
        $menu->submenuses()->sync($request->input('submenuses', []));

        return redirect()->route('admin.menus.index');
    }

    public function show(Menu $menu)
    {
        abort_if(Gate::denies('menu_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $menu->load('submenuses', 'page');

        return view('admin.menus.show', compact('menu'));
    }

    public function destroy(Menu $menu)
    {
        abort_if(Gate::denies('menu_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $menu->delete();

        return back();
    }

    public function massDestroy(MassDestroyMenuRequest $request)
    {
        $menus = Menu::find(request('ids'));

        foreach ($menus as $menu) {
            $menu->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
