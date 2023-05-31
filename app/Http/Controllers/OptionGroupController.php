<?php

namespace App\Http\Controllers;

use App\Models\OptionGroup;
use App\Http\Requests\StoreOptionGroupRequest;
use App\Http\Requests\UpdateOptionGroupRequest;

class OptionGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $resultList = OptionGroup::paginate(config('constants.RECORD_PER_PAGE'));

        return view('console/options_group/index', compact('resultList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOptionGroupRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(OptionGroup $optionGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OptionGroup $optionGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOptionGroupRequest $request, OptionGroup $optionGroup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OptionGroup $optionGroup)
    {
        //
    }
}
