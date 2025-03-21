<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $objs = Banner::orderBy('id', 'desc')
            ->get();

        return view('admin.banners.index')
            ->with([
                'objs' => $objs,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.banners.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048|dimensions:width=1320,height=450',
            'url' => 'nullable|string|max:255',
            'datetime_start' => 'required|date',
            'datetime_end' => 'required|date',
            'sort_order' => 'required|integer|min:1',
        ]);

        $obj = new Banner();
        $obj->url = $request->url ?: null;
        $obj->datetime_start = Carbon::parse($request->datetime_start);
        $obj->datetime_end = Carbon::parse($request->datetime_end);
        $obj->sort_order = $request->sort_order;
        $obj->save();

        if ($request->hasfile('image')) {
            $image = $request->file('image');
            $imageName = str()->random(5) . '.' . $request->file()->extension();
            Storage::put('public/banner/' . $imageName, $image);

            $obj->image = 'banner/' . $imageName;
            $obj->update();
        }

        return to_route('admin.banners.index')
            ->with([
                'success' => trans('app.product') . ' ' . trans('app.added'),
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $obj = Banner::findOrFail($id);

        return view('admin.banners.edit')
            ->with([
                'obj' => $obj,
            ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048|dimensions:width=1320,height=450',
            'url' => 'nullable|string|max:255',
            'datetime_start' => 'required|date',
            'datetime_end' => 'required|date',
            'sort_order' => 'required|integer|min:1',
        ]);

        $obj = Banner::findOrFail($id);
        $obj->url = $request->url ?: null;
        $obj->datetime_start = Carbon::parse($request->datetime_start);
        $obj->datetime_end = Carbon::parse($request->datetime_end);
        $obj->sort_order = $request->sort_order;
        $obj->save();

        if ($request->hasfile('image')) {
            if (isset($obj->image)) {
                Storage::delete($obj->image);
            }

            $image = $request->file('image');
            $imageName = str()->random(5) . '.' . $request->file()->extension();
            Storage::put('public/banner/' . $imageName, $image);

            $obj->image = 'banner/' . $imageName;
            $obj->update();
        }

        return to_route('admin.banners.index')
            ->with([
                'success' => trans('app.product') . ' ' . trans('app.updated'),
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $obj = Banner::findOrFail($id);
        if (isset($obj->image)) {
            Storage::delete($obj->image);
        }
        $obj->delete();

        return to_route('admin.banners.index')
            ->with([
                'success' => trans('app.banner') . ' ' . trans('app.deleted'),
            ]);
    }
}
