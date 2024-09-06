<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TagController extends Controller
{

    public function index()
    {
        return view('backend.tags.index');
    }


    public function create()
    {
        return view('backend.tags.create');

    }


    public function store(Request $request)
    {

    }


    public function show($id)
    {
        return view('backend.tags.show');

    }

    public function edit($id)
    {
        return view('backend.tags.edit');

    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {

    }
}
