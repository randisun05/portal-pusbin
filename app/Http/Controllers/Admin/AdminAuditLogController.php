<?php

namespace App\Http\Controllers\Admin;

use App\Models\AuditLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminAuditLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $logs = AuditLog::query()
            ->when($request->action, fn ($query, $action) => $query->where('action', $action))
            ->when($request->user_name, fn ($query, $name) => $query->where('user_name', 'like', '%' . $name . '%'))
            ->latest()
            ->paginate(25)
            ->withQueryString();

        return view('admin.auditlog.index', [
            'logs' => $logs,
            'actions' => AuditLog::select('action')->distinct()->pluck('action'),
        ]);
    }
}
