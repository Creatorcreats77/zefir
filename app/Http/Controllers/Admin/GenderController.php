<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gender;
use Illuminate\Http\Request;

class GenderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $objs = Gender::orderBy('id')
            ->withCount('categories', 'products')
            ->get();

        return view('admin.genders.index')
            ->with([
                'objs' => $objs,
            ]);
    }
}
