<?php

namespace App\Http\Controllers\logistic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StorageController extends Controller
{
    public function index(){
        return view('logistic.storage.rawmaterial.index');
    }

    public function scan(){
        return view('logistic.storage.rawmaterial.scan');
    }

}
