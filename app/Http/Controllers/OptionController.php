<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\StoreOptionRequest;
use App\Http\Requests\UpdateOptionRequest;
use App\Models\Option;

class OptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //! Search Area
        $resultList = Option::query()->where('id','>',0);
        $filters = $request->all();
        if(array_key_exists('name', $filters)){
            $resultList->where('name', 'like','%'.$filters['name'].'%');
        }

        $resultList->orderby('deleted_at', 'asc');
        $resultList->orderby('name', 'asc');

        //! Display List

        $resultList = Option::paginate(config('constants.RECORD_PER_PAGE'));
        return view('console/options/index', compact('resultList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $option = new Option();
        $option->id = 0;
        $error = [];
        return view('console/options/edit', compact('error','option'));
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOptionRequest $request) : RedirectResponse
    {
        $validatedData = $request->validate($request->rules());
        $opt_group_ID = $request->input('status');
        $option = new Option();
        $option->name = $validatedData['name'];
        $option->code = $validatedData['code'];
        $option->group_id = $opt_group_ID;
        $option->save();
        return Redirect::route('options.edit', $option->id)->with('status','Option record has been created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Option $option)
    {
        $error = [];
        return view('console/options/edit', compact('error','option'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Option $option)
    {
        $error = [];
        return view('console/options/edit', compact('error','option'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOptionRequest $request, Option $option) : RedirectResponse
    {
        $validatedData = $request->validate($request->rules());
        $option = new Option();
        $option->name = $validatedData['name'];
        $option->code = $validatedData['code'];
        $option->save();
        return Redirect::route('options.edit', $option->id)->with('status','Option record has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Option $option) : RedirectResponse
    {
        $option->delete();
        return Redirect::route('options.index')->with('status','Option has been deleted.');
    }
}
