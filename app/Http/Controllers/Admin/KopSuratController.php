<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class KopSuratController extends Controller
{
    public function index()
    {
        return view('admin.kop-surat.index');
    }
}
