<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class AuditLogsController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('audit_log_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            // audit_logs cresce sem limite (todo CRUD dos models com a
            // trait Auditable gera uma linha) — precisa de server-side de
            // verdade, "::all()" sem paginacao era o maior risco de
            // degradacao de performance do admin a longo prazo.
            $query = AuditLog::with('user')->select(sprintf('%s.*', (new AuditLog)->table));
            $table = Datatables::of($query);

            // Yajra so evita a pipeline de compilacao Blade (que checa
            // view()->exists() a cada chamada) quando o conteudo passado
            // e um Closure -- uma string literal como '&nbsp;' e tratada
            // como possivel template Blade e recompilada em toda linha,
            // ~12ms/chamada mesmo sem nenhuma sintaxe Blade de verdade.
            $table->addColumn('placeholder', fn () => '&nbsp;');
            $table->addColumn('actions', fn () => '&nbsp;');

            $table->editColumn('actions', function ($row) {
                if (Gate::denies('audit_log_show')) {
                    return '';
                }

                return sprintf(
                    '<a class="btn btn-xs btn-primary" href="%s">%s</a>',
                    route('admin.audit-logs.show', $row->id),
                    trans('global.view')
                );
            });

            $table->editColumn('subject_id', function ($row) {
                if (! $row->subject_id) {
                    return '';
                }

                $routePart = strcmp(substr($row->subject_type, -1), 'y') === 0
                    ? strtolower(rtrim($row->subject_type, 'y')) . 'ies'
                    : strtolower($row->subject_type) . 's';

                return sprintf(
                    '<a href="%s">#%s</a>',
                    route('admin.' . $routePart . '.show', $row->subject_id),
                    $row->subject_id
                );
            });

            $table->editColumn('subject_type', function ($row) {
                return $row->subject_type ? trans('cruds.' . strtolower($row->subject_type) . '.title') : '';
            });

            $table->editColumn('user_id', function ($row) {
                if (! $row->user_id) {
                    return '';
                }

                return sprintf(
                    '<a href="%s">%s</a>',
                    route('admin.users.show', $row->user_id),
                    $row->user->name ?? ''
                );
            });

            $table->rawColumns(['actions', 'placeholder', 'subject_id', 'user_id']);

            return $table->make(true);
        }

        return view('admin.auditLogs.index');
    }

    public function show(AuditLog $auditLog)
    {
        abort_if(Gate::denies('audit_log_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.auditLogs.show', compact('auditLog'));
    }
}
