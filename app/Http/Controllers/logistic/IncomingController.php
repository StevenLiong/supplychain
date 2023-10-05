<?php

namespace App\Http\Controllers\logistic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IncomingController extends Controller
{
    public function index()
    {
        return view('logistic.receiving.index');
    }

    public function create()
    {
        return view('logistic.receiving.create');
    }

    public function store(Request $request)
    {
    }

    public function show()
    {
    }

    public function edit()
    {
        return view('logistic.receiving.edit');
    }

    public function update(Request $request)
    {
    }


    public function print()
    {
        return view('logistic.receiving.print');
    }
}
