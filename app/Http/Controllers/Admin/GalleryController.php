<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyGalleryRequest;
use App\Http\Requests\StoreGalleryRequest;
use App\Http\Requests\UpdateGalleryRequest;
use App\Models\Category;
use App\Models\Gallery;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class GalleryController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('gallery_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            // "media" (nao "photos") e o nome real da relacao do Spatie
            // Media Library; "photos" e so um accessor (getPhotosAttribute)
            // por cima dela. Eager-carregar "media" evita 1 query extra por
            // linha quando editColumn('photos') acessa $row->photos abaixo.
            $query = Gallery::with(['categories', 'media'])->select(sprintf('%s.*', (new Gallery)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'gallery_show';
                $editGate      = 'gallery_edit';
                $deleteGate    = 'gallery_delete';
                $crudRoutePart = 'galleries';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
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
            $table->editColumn('categories', function ($row) {
                $labels = [];
                foreach ($row->categories as $category) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $category->title);
                }

                return implode(' ', $labels);
            });

            // "categories" nao e uma coluna real da tabela galleries (vem
            // de category_gallery via belongsToMany) — sem isso, a busca
            // global/por coluna gera "WHERE categories.title LIKE ..."
            // contra uma tabela nunca joinada e quebra com erro de SQL.
            $table->filterColumn('categories', function ($query, $keyword) {
                $query->whereHas('categories', function ($categoriesQuery) use ($keyword) {
                    $categoriesQuery->where('categories.title', 'like', "%{$keyword}%");
                });
            });
            $table->orderColumn('categories', function ($query, $order) {
                $query->orderBy(
                    Category::select('title')
                        ->join('category_gallery', 'category_gallery.category_id', '=', 'categories.id')
                        ->whereColumn('category_gallery.gallery_id', 'galleries.id')
                        ->orderBy('title')
                        ->limit(1),
                    $order
                );
            });

            $table->rawColumns(['actions', 'placeholder', 'photos', 'categories']);

            return $table->make(true);
        }

        $categories = Category::select('id', 'title')->get();

        return view('admin.galleries.index', compact('categories'));
    }

    public function create()
    {
        abort_if(Gate::denies('gallery_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = Category::pluck('title', 'id');

        return view('admin.galleries.create', compact('categories'));
    }

    public function store(StoreGalleryRequest $request)
    {
        $gallery = Gallery::create($request->all());
        $gallery->categories()->sync($request->input('categories', []));
        foreach ($request->input('photos', []) as $file) {
            $gallery->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('photos');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $gallery->id]);
        }

        return redirect()->route('admin.galleries.index');
    }

    public function edit(Gallery $gallery)
    {
        abort_if(Gate::denies('gallery_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = Category::pluck('title', 'id');

        $gallery->load('categories');

        return view('admin.galleries.edit', compact('categories', 'gallery'));
    }

    public function update(UpdateGalleryRequest $request, Gallery $gallery)
    {
        $gallery->update($request->all());
        $gallery->categories()->sync($request->input('categories', []));
        if (count($gallery->photos) > 0) {
            foreach ($gallery->photos as $media) {
                if (! in_array($media->file_name, $request->input('photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $gallery->photos->pluck('file_name')->toArray();
        foreach ($request->input('photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $gallery->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('photos');
            }
        }

        return redirect()->route('admin.galleries.index');
    }

    public function show(Gallery $gallery)
    {
        abort_if(Gate::denies('gallery_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $gallery->load('categories');

        return view('admin.galleries.show', compact('gallery'));
    }

    public function destroy(Gallery $gallery)
    {
        abort_if(Gate::denies('gallery_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $gallery->delete();

        return back();
    }

    public function massDestroy(MassDestroyGalleryRequest $request)
    {
        $galleries = Gallery::find(request('ids'));

        foreach ($galleries as $gallery) {
            $gallery->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('gallery_create') && Gate::denies('gallery_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Gallery();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
