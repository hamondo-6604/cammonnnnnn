<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        // TODO: return view('system.feedback.index');
        return view('dashboard.admin_list');
    }
    
    public function create()
    {
        // TODO: return view('system.feedback.create');
        return view('dashboard.admin_list');
    }
    
    public function store(Request $request)
    {
        return redirect()->back();
    }
    
    public function show($id)
    {
        // TODO: return view('system.feedback.show');
        return view('dashboard.admin_list');
    }
    
    public function edit($id)
    {
        // TODO: return view('system.feedback.edit');
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
