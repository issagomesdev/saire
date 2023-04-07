@extends('layouts.admin')
@section('content')
@can('publication_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.publications.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.publication.title') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.publication.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Publication">
            <thead>
                <tr>
                    <th width="10"> </th>
                    <th> </th>
                    <th>
                        {{ trans('cruds.publication.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.publication.fields.title') }}
                    </th>
                    <th>
                        {{ trans('cruds.publication.fields.categories') }}
                    </th>
                    <th>
                        {{ trans('cruds.publication.fields.created_at') }}
                    </th>
                    <th>
                        {{ trans('cruds.publication.fields.updated_at') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
                <tr>
                    <td> </td>
                    <td>
                    <!-- <select class="search">
                       <option value>{{ trans('global.all') }}</option>
                       <option value="fav">fav</option>
                       <option value="nofav">nofav</option>                           
                        </select> -->
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <select class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach($categories as $key => $item)
                                <option value="{{ $item->title }}">{{ $item->title }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                    </td>
                </tr>
            </thead>
        </table>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>

function favItem(element) {
    const fav = $(element).find('i');
    if (fav.hasClass('fa-regular')) {
        fav.removeClass('fa-regular').addClass('fa-solid');

        $.ajax({
            url: '/admin/favpublications/',
            method: 'GET',
            data: {
                id: element.id,
                status: 1
            },
            success: function(response) {
                
            },
            error: function(jqXHR, textStatus, errorThrown) {
                
            }
        });

    } else if (fav.hasClass('fa-solid')) {
        fav.removeClass('fa-solid').addClass('fa-regular');

        $.ajax({
            url: "{{ route('admin.publications.favpublications') }}",
            method: 'GET',
            data: {
                id: element.id,
                status: 0
            },
            success: function(response) {
                
            },
            error: function(jqXHR, textStatus, errorThrown) {
                
            }
        });
    }
}

</script>
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('publication_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.publications.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
          return entry.id
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }
        })
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.publications.index') }}",
    columns: [
{ data: 'placeholder', name: 'placeholder' },
{ data: 'fav', name: 'fav', sortable: false, searchable: false  },
{ data: 'id', name: 'id' },
{ data: 'title', name: 'title' },
{ data: 'categories', name: 'categories.title' },
{ data: 'created_at', name: 'created_at' },
{ data: 'updated_at', name: 'updated_at' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-Publication').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
let visibleColumnsIndexes = null;
$('.datatable thead').on('input', '.search', function () {
      let strict = $(this).attr('strict') || false
      let value = strict && this.value ? "^" + this.value + "$" : this.value

      let index = $(this).parent().index()
      if (visibleColumnsIndexes !== null) {
        index = visibleColumnsIndexes[index]
      }

      table
        .column(index)
        .search(value, strict)
        .draw()
  });
table.on('column-visibility.dt', function(e, settings, column, state) {
      visibleColumnsIndexes = []
      table.columns(":visible").every(function(colIdx) {
          visibleColumnsIndexes.push(colIdx);
      });
  })
});

</script>
@endsection