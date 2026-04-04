<?php

namespace App\Http\Controllers\Admin\Operations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index()
    {
        // TODO: return view('operations.promotions.index');
        return view('dashboard.admin_list');
    }
    
    public function create()
    {
        // TODO: return view('operations.promotions.create');
        return view('dashboard.admin_list');
    }
    
    public function store(Request $request)
    {
        return redirect()->back();
    }
    
    public function show($id)
    {
        // TODO: return view('operations.promotions.show');
        return view('dashboard.admin_list');
    }
    
    public function edit($id)
    {
        // TODO: return view('operations.promotions.edit');
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
