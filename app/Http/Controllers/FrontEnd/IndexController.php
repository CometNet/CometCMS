<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\FrontEnd\Controller;

class IndexController extends Controller
{
    public function index()
    {
        $option = getSlide(2);
        var_dump($option);die;
    }
}
