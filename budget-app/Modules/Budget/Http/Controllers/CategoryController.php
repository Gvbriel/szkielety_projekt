<?php

namespace Modules\Budget\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Budget\Entities\Category;
use Modules\Budget\Http\Requests\StoreCategoryRequest;

class CategoryController extends Controller
{


    public function getCategories()
    {
        $cat = Category::where('owner_id', Auth::user()->id)->orWhere(function ($query) {
            $query->where('owner_id', 0);
        })->get();

        return response()->json($cat);
    }

    public function getCategoriesNames()
    {
        $cat = Category::where('owner_id', Auth::user()->id)->orWhere(function ($query) {
            $query->where('owner_id', 0)->orWhere('owner_id', null);
        })->get()->sortBy('id');

        return response()->json($cat);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('budget::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(StoreCategoryRequest $request)
    {
        $cat = Category::create([
            'name' => $request->name,
            'owner_id' => Auth::user()->id,
            'color' => $request->color
        ]);

        return response()->json($cat);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('budget::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('budget::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
