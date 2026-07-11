<?php

namespace App\Support\DataTables;

use Illuminate\Support\Facades\Gate;

/**
 * Gera o mesmo HTML de resources/views/partials/datatablesActions.blade.php
 * (link ver/editar + form de excluir, cada um atrás de um Gate) sem passar
 * pelo View engine — chamado uma vez por linha em toda listagem admin, e
 * view()->render() mediu ~11ms por chamada nesse projeto (contra <0.01ms de
 * route()), virando o gargalo dominante de qualquer tabela com mais que
 * poucas dezenas de linhas por página. Mesmo HTML, mesma autorização, só sem
 * o custo de resolver/compilar/renderizar uma View a cada linha.
 */
class RowActionsHtml
{
    public static function make(object $row, string $viewGate, string $editGate, string $deleteGate, string $crudRoutePart): string
    {
        $html = '';

        if (Gate::allows($viewGate)) {
            $html .= sprintf(
                '<a class="btn btn-xs btn-primary" href="%s">%s</a>',
                route('admin.'.$crudRoutePart.'.show', $row->id),
                e(trans('global.view'))
            );
        }

        if (Gate::allows($editGate)) {
            $html .= sprintf(
                '<a class="btn btn-xs btn-info" href="%s">%s</a>',
                route('admin.'.$crudRoutePart.'.edit', $row->id),
                e(trans('global.edit'))
            );
        }

        if (Gate::allows($deleteGate)) {
            $html .= sprintf(
                '<form action="%s" method="POST" onsubmit="return confirm(\'%s\');" style="display: inline-block;">'
                .'<input type="hidden" name="_method" value="DELETE">'
                .'<input type="hidden" name="_token" value="%s">'
                .'<input type="submit" class="btn btn-xs btn-danger" value="%s">'
                .'</form>',
                route('admin.'.$crudRoutePart.'.destroy', $row->id),
                e(trans('global.areYouSure')),
                csrf_token(),
                e(trans('global.delete'))
            );
        }

        return $html;
    }
}
