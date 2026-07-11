<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyPageRequest;
use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;
use App\Models\Page;
use App\Support\DataTables\RowActionsHtml;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PageController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('page_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            // "media" (nao "photos") e o nome real da relacao do Spatie
            // Media Library; "photos" e so um accessor por cima dela.
            // Eager-carregar "media" evita 1 query extra por linha quando
            // editColumn('photos') acessa $row->photos abaixo.
            $query = Page::with(['media'])->select(sprintf('%s.*', (new Page)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', fn () => '&nbsp;');
            $table->addColumn('actions', fn () => '&nbsp;');

            $table->editColumn('actions', function ($row) {
                return RowActionsHtml::make($row, 'page_show', 'page_edit', 'page_delete', 'pages');
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('title', function ($row) {
                return $row->title ? $row->title : '';
            });
            $table->editColumn('photos', function ($row) {
                if (! $row->photos) {
                    return '';
                }
                $links = [];
                foreach ($row->photos as $media) {
                    $links[] = '<a href="' . $media->getUrl() . '" target="_blank"><img src="' . $media->getUrl('thumb') . '" width="50px" height="50px"></a>';
                }

                return implode(' ', $links);
            });

            $table->rawColumns(['actions', 'placeholder', 'photos']);

            return $table->make(true);
        }

        return view('admin.pages.index');
    }

    public function create()
    {
        abort_if(Gate::denies('page_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.pages.create');
    }

    public function store(StorePageRequest $request)
    {
        $page = Page::create($request->all());

        foreach ($request->input('photos', []) as $file) {
            $page->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('photos');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $page->id]);
        }

        return redirect()->route('admin.pages.index');
    }

    public function edit(Page $page)
    {
        abort_if(Gate::denies('page_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.pages.edit', compact('page'));
    }

    public function update(UpdatePageRequest $request, Page $page)
    {
        $page->update($request->all());

        if (count($page->photos) > 0) {
            foreach ($page->photos as $media) {
                if (! in_array($media->file_name, $request->input('photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $page->photos->pluck('file_name')->toArray();
        foreach ($request->input('photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $page->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('photos');
            }
        }

        return redirect()->route('admin.pages.index');
    }

    public function show(Page $page)
    {
        abort_if(Gate::denies('page_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.pages.show', compact('page'));
    }

    public function destroy(Page $page)
    {
        abort_if(Gate::denies('page_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $page->delete();

        return back();
    }

    public function massDestroy(MassDestroyPageRequest $request)
    {
        $pages = Page::find(request('ids'));

        foreach ($pages as $page) {
            $page->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('page_create') && Gate::denies('page_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Page();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
