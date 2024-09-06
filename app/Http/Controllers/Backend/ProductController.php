<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        return view('backend.products.index');
    }


    public function create()
    {
        return view('backend.products.create');

    }


    public function store(Request $request)
    {

    }


    public function show($id)
    {
        return view('backend.products.show');

    }

    public function edit($id)
    {
        return view('backend.products.edit');

    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {

    }
}
