<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyPublicationRequest;
use App\Http\Requests\StorePublicationRequest;
use App\Http\Requests\UpdatePublicationRequest;
use App\Models\Category;
use App\Models\Publication;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PublicationsController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('publication_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Publication::with(['categories'])->select(sprintf('%s.*', (new Publication)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');
            $table->addColumn('fav', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'publication_show';
                $editGate      = 'publication_edit';
                $deleteGate    = 'publication_delete';
                $crudRoutePart = 'publications';

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
            $table->editColumn('categories', function ($row) {
                $labels = [];
                foreach ($row->categories as $category) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $category->title);
                }

                return implode(' ', $labels);
            });

            $table->editColumn('fav', function ($row) {

                if($row->status == 1){
                    return '<div id=' . $row->id . " ". 'onclick="favItem(this)" class="fav"> <i class="fa-solid fa-star"></i> </div>';
                } elseif($row->status == 0) {
                    return '<div id=' . $row->id . " ". 'onclick="favItem(this)" class="fav"> <i class="fa-regular fa-star"></i> </div>';                   
                }                                       
            });

            $table->rawColumns(['actions', 'placeholder', 'categories', 'fav']);

            return $table->make(true);
        }

        $categories = Category::get();

        return view('admin.publications.index', compact('categories'));
    }

    public function favPublications(Request $request){

        $publication = Publication::where('id', $request->id)->update(['status' => $request->status]);

        return response()->json('sucess', Response::HTTP_CREATED);
    }

    public function create()
    {
        abort_if(Gate::denies('publication_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = Category::pluck('title', 'id');

        return view('admin.publications.create', compact('categories'));
    }

    public function store(StorePublicationRequest $request)
    {
        $publication = Publication::create($request->all());
        $publication->categories()->sync($request->input('categories', []));
        foreach ($request->input('
        photos', []) as $file) {
            $publication->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('photos');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $publication->id]);
        }

        return redirect()->route('admin.publications.index');
    }

    public function edit(Publication $publication)
    {
        abort_if(Gate::denies('publication_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = Category::pluck('title', 'id');

        $publication->load('categories');

        return view('admin.publications.edit', compact('categories', 'publication'));
    }

    public function update(UpdatePublicationRequest $request, Publication $publication)
    {
        $publication->update($request->all());
        $publication->categories()->sync($request->input('categories', []));
        if (count($publication->photos) > 0) {
            foreach ($publication->photos as $media) {
                if (! in_array($media->file_name, $request->input('photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $publication->photos->pluck('file_name')->toArray();
        foreach ($request->input('photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $publication->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('photos');
            }
        }

        return redirect()->route('admin.publications.index');
    }

    public function show(Publication $publication)
    {
        abort_if(Gate::denies('publication_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $publication->load('categories');

        return view('admin.publications.show', compact('publication'));
    }

    public function destroy(Publication $publication)
    {
        abort_if(Gate::denies('publication_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $publication->delete();

        return back();
    }

    public function massDestroy(MassDestroyPublicationRequest $request)
    {
        $publications = Publication::find(request('ids'));

        foreach ($publications as $publication) {
            $publication->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('publication_create') && Gate::denies('publication_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Publication();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
