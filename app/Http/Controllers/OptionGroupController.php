<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\StoreOptionGroupRequest;
use App\Http\Requests\UpdateOptionGroupRequest;
use App\Models\OptionGroup;

class OptionGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $resultList = OptionGroup::withTrashed()->where('id','>',0);
        $filters = $request->all();
        if(array_key_exists('name', $filters)){
            $resultList->where('name', 'like','%'.$filters['name'].'%');
        }
        $resultList->orderby('deleted_at', 'desc');
        $resultList->orderby('name', 'asc');
        $resultList = OptionGroup::paginate(config('constants.RECORD_PER_PAGE'));
        return view('console/options_group/index', compact('resultList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $optionGroup = new OptionGroup();
        $optionGroup->id = 0;
        $error = [];
        return view('console/options_group/edit', compact('error','optionGroup'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOptionGroupRequest $request)  : RedirectResponse
    {
        $validatedData = $request->validate($request->rules());
        $optionGroup = new OptionGroup();
        $optionGroup = $this->saveRecordOptionGroup($optionGroup , $validatedData);
        return Redirect::route('optionsgroups.edit', $optionGroup->id)->with('status','Record has been created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(OptionGroup $optionGroup)
    {
        $error = [];
        return view('console/options_group/edit', compact('error','optionGroup'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OptionGroup $optionGroup) 
    {
        $error = [];
        return view('console/options_group/edit', compact('error','optionGroup'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOptionGroupRequest $request, OptionGroup $optionGroup) : RedirectResponse
    {
        $validatedData = $request->validate($request->rules());
        $optionGroup = $this->saveRecordOptionGroup($optionGroup , $validatedData);
        return Redirect::route('optionsgroups.edit', $optionGroup->id)->with('status','Record record has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OptionGroup $optionGroup) : RedirectResponse
    {
        $optionGroup->delete();
        return Redirect::route('optionsgroups.index')->with('status','Status has been disabled.');
    }

    protected function saveRecordOptionGroup(OptionGroup $optionGroup , array $data) : OptionGroup
    {
        $optionGroup->name = $data['name'];
        $optionGroup->description = $data['description'];
        $optionGroup->save();
        return $optionGroup;
    }
}
