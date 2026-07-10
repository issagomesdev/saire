<?php

namespace Tests\Concerns;

/**
 * Monta a query string que o DataTables.js manda de verdade numa requisicao
 * server-side (columns[n][data]/[name]/[searchable]/[orderable]/[search],
 * search[value] global, order[0][column]/[dir]) — sem isso os testes nao
 * exercitam o mesmo caminho de codigo do Yajra que o navegador exercita.
 */
trait BuildsDataTablesRequests
{
    protected function dataTablesUrl(
        string $route,
        array $columnNames,
        string $globalSearch = '',
        array $columnSearches = [],
        ?array $order = null
    ): string {
        $params = [
            'draw' => 1,
            'start' => 0,
            'length' => 10,
            'search' => ['value' => $globalSearch, 'regex' => 'false'],
            'columns' => [],
        ];

        foreach (array_values($columnNames) as $index => $name) {
            $params['columns'][$index] = [
                'data' => $name,
                'name' => $name,
                'searchable' => 'true',
                'orderable' => 'true',
                'search' => ['value' => $columnSearches[$name] ?? '', 'regex' => 'false'],
            ];
        }

        if ($order) {
            $params['order'] = [['column' => $order[0], 'dir' => $order[1]]];
        }

        return $route . '?' . http_build_query($params);
    }

    /**
     * getJson() do Laravel não seta X-Requested-With por padrão — é
     * exatamente esse header que $request->ajax() verifica nos
     * controllers do admin para decidir entre a resposta JSON do Yajra
     * e a view HTML normal. Sem ele, o teste cai no branch errado.
     */
    protected function getDataTablesJson(string $url)
    {
        return $this->getJson($url, ['X-Requested-With' => 'XMLHttpRequest']);
    }
}
