<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * Test画面を表示
     */
    public function index()
    {
        return view('test');
    }
}
