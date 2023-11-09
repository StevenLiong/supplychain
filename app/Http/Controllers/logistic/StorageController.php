<?php

namespace App\Http\Controllers\logistic;

use App\Http\Controllers\Controller;


class StorageController extends Controller
{
    // raw Material
    public function indexHome(){
        return view('logistic.storage.rawmaterial.index');
    }

    public function indexFinishedGood(){
        return view('logistic.storage.finishedgood.index');
    }

    
}
