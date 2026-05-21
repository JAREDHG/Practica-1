<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Audit;

class AuditController extends Controller
{
    
    public function index()
    {
        $audits = Audit::latest()->paginate(20);
        return view('admin.audits.index', compact('audits'));
    }
    public function show(Audit $audit)
    {
        return view('admin.audits.show', compact('audit'));
    }
}
