<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        // TODO: return view('system.roles.index');
        return view('dashboard.admin_list');
    }
    
    public function create()
    {
        // TODO: return view('system.roles.create');
        return view('dashboard.admin_list');
    }
    
    public function store(Request $request)
    {
        return redirect()->back();
    }
    
    public function show($id)
    {
        // TODO: return view('system.roles.show');
        return view('dashboard.admin_list');
    }
    
    public function edit($id)
    {
        // TODO: return view('system.roles.edit');
        return view('dashboard.admin_list');
    }
    
    public function update(Request $request, $id)
    {
        return redirect()->back();
    }
    
    public function destroy($id)
    {
        return redirect()->back();
    }
}
