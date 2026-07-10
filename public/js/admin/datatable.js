/**
 * Helper compartilhado para inicializar as listagens (Yajra DataTables
 * server-side) do admin. Centraliza o que antes era duplicado em cada
 * view: botao de exclusao em massa, busca por coluna com debounce, e
 * ajuste de colunas ao trocar de aba.
 */
(function (window, $) {
    'use strict';

    function debounce(fn, delay) {
        let timer = null;

        return function (...args) {
            clearTimeout(timer);
            timer = setTimeout(() => fn.apply(this, args), delay);
        };
    }

    function buildDeleteButton(options) {
        if (!options.deleteRoute) {
            return null;
        }

        return {
            text: options.deleteButtonLabel,
            url: options.deleteRoute,
            className: 'btn-danger',
            action: function (e, dt, node, config) {
                const ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
                    return entry.id;
                });

                if (ids.length === 0) {
                    alert(options.zeroSelectedLabel);

                    return;
                }

                if (confirm(options.areYouSureLabel)) {
                    $.ajax({
                        headers: { 'x-csrf-token': window._token },
                        method: 'POST',
                        url: config.url,
                        data: { ids: ids, _method: 'DELETE' },
                    }).done(function () {
                        location.reload();
                    });
                }
            },
        };
    }

    /**
     * @param {string} tableSelector seletor do <table>, ex: '.datatable-Gallery'
     * @param {object} options
     *   ajax: url do endpoint (obrigatorio)
     *   columns: array de colunas do DataTables (obrigatorio)
     *   order: ordenacao inicial, ex: [[1, 'desc']] (default: [[1, 'desc']])
     *   deleteRoute / deleteButtonLabel / zeroSelectedLabel / areYouSureLabel: exclusao em massa (opcional)
     *   extra: config adicional do DataTables mesclada por cima (ex: rowReorder)
     *   searchDebounceMs: atraso do debounce da busca por coluna (default: 400)
     */
    window.initAdminDataTable = function (tableSelector, options) {
        options = options || {};

        const dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons);
        const deleteButton = buildDeleteButton(options);
        if (deleteButton) {
            dtButtons.push(deleteButton);
        }

        const config = $.extend(true, {
            buttons: dtButtons,
            processing: true,
            serverSide: true,
            retrieve: true,
            ajax: options.ajax,
            columns: options.columns,
            orderCellsTop: true,
            order: options.order || [[1, 'desc']],
            pageLength: 100,
        }, options.extra || {});

        const table = $(tableSelector).DataTable(config);

        $('a[data-toggle="tab"]').on('shown.bs.tab click', function () {
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        });

        let visibleColumnsIndexes = null;

        const applyColumnSearch = debounce(function (input) {
            const strict = $(input).attr('strict') || false;
            const value = strict && input.value ? '^' + input.value + '$' : input.value;

            let index = $(input).parent().index();
            if (visibleColumnsIndexes !== null) {
                index = visibleColumnsIndexes[index];
            }

            table.column(index).search(value, Boolean(strict)).draw();
        }, options.searchDebounceMs || 400);

        $(tableSelector).find('thead').on('input', '.search', function () {
            applyColumnSearch(this);
        });

        table.on('column-visibility.dt', function () {
            visibleColumnsIndexes = [];
            table.columns(':visible').every(function (colIdx) {
                visibleColumnsIndexes.push(colIdx);
            });
        });

        return table;
    };
})(window, jQuery);
