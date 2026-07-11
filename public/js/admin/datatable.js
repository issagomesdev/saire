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
     * Cria (uma vez por tabela) o overlay de carregamento moderno que
     * substitui o ".dataTables_processing" padrao, e liga/desliga via o
     * evento "processing.dt" -- disparado pelo proprio DataTables a cada
     * inicio/fim de requisicao AJAX (busca, ordenacao, paginacao).
     */
    function buildLoadingOverlay(tableSelector, table) {
        const $wrapper = $(tableSelector).closest('.dataTables_wrapper');
        if ($wrapper.length === 0 || $wrapper.find('> .admin-datatable-overlay').length > 0) {
            return;
        }

        const $overlay = $(
            '<div class="admin-datatable-overlay" aria-hidden="true">' +
            '<div class="admin-datatable-overlay__spinner"></div>' +
            '</div>'
        ).appendTo($wrapper);

        table.on('processing.dt', function (e, settings, processing) {
            $overlay.toggleClass('is-visible', Boolean(processing));
        });
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
     *   globalSearchDelayMs: atraso do debounce da busca global nativa do DataTables (default: 400)
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
            // Sem isso, o input de busca global nativo do DataTables
            // (renderizado pelo "f" do dom) dispara 1 requisicao AJAX
            // por tecla digitada -- com N requisicoes concorrentes de
            // uma palavra de N letras competindo entre si, a busca
            // parece travada/quebrada. searchDelay debounca no proprio
            // DataTables, sem precisar reimplementar o binding do input.
            searchDelay: options.globalSearchDelayMs || 400,
        }, options.extra || {});

        const table = $(tableSelector).DataTable(config);

        // Com serverSide:true o wrapper (".dataTables_wrapper", onde o
        // overlay e anexado) so fica pronto no DOM depois que o primeiro
        // draw AJAX resolve -- criar o overlay direto apos ".DataTable()"
        // falha silenciosamente (wrapper ainda nao existe). "init.dt" e o
        // evento que o proprio DataTables dispara quando a inicializacao
        // (inclusive esse primeiro draw) termina.
        table.on('init.dt', function () {
            buildLoadingOverlay(tableSelector, table);
        });

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
