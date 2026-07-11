<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCategoryRequest;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Support\DataTables\RowActionsHtml;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CategoriesController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Category::query()->select(sprintf('%s.*', (new Category)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', fn () => '&nbsp;');
            $table->addColumn('actions', fn () => '&nbsp;');

            $table->editColumn('actions', function ($row) {
                return RowActionsHtml::make($row, 'category_show', 'category_edit', 'category_delete', 'categories');
            });

            $table->editColumn('title', function ($row) {
                return $row->title ? $row->title : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.categories.index');
    }

    public function create()
    {
        abort_if(Gate::denies('category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.categories.create');
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->all());

        return redirect()->route('admin.categories.index');
    }

    public function edit(Category $category)
    {
        abort_if(Gate::denies('category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.categories.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->all());

        return redirect()->route('admin.categories.index');
    }

    public function show(Category $category)
    {
        abort_if(Gate::denies('category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.categories.show', compact('category'));
    }

    public function destroy(Category $category)
    {
        abort_if(Gate::denies('category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $category->delete();

        return back();
    }

    public function massDestroy(MassDestroyCategoryRequest $request)
    {
        $categories = Category::find(request('ids'));

        foreach ($categories as $category) {
            $category->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
