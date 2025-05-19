<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudentParent;
use Illuminate\Http\Request;

class ParentController extends Controller
{
    public function index()
    {
        $parents = StudentParent::all();
        return view('admin.parents.index', compact('parents'));
    }
}
