<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SeatController extends Controller
{
    public function index()    { return view('dashboard.admin_list'); }
    public function create()   { return view('dashboard.admin_list'); }
    public function store(Request $request)  { return redirect()->back(); }
    public function show($id)  { return view('dashboard.admin_list'); }
    public function edit($id)  { return view('dashboard.admin_list'); }
    public function update(Request $request, $id) { return redirect()->back(); }
    public function destroy($id) { return redirect()->back(); }
}
