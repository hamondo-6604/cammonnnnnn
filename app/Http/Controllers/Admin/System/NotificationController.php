<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        // TODO: return view('system.notifications.index');
        return view('dashboard.admin_list');
    }
    
    public function create()
    {
        // TODO: return view('system.notifications.create');
        return view('dashboard.admin_list');
    }
    
    public function store(Request $request)
    {
        return redirect()->back();
    }
    
    public function show($id)
    {
        // TODO: return view('system.notifications.show');
        return view('dashboard.admin_list');
    }
    
    public function edit($id)
    {
        // TODO: return view('system.notifications.edit');
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
