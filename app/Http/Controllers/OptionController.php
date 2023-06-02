<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\StoreOptionRequest;
use App\Http\Requests\UpdateOptionRequest;
use App\Models\Option;
use App\Models\OptionGroup; 

class OptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $resultList = Option::withTrashed()->where('id','>',0);
        $filters = $request->all();
        if(array_key_exists('name', $filters)){
            $resultList->where('name', 'like','%'.$filters['name'].'%');
        }
        $resultList->orderby('deleted_at', 'desc');
        $resultList->orderby('name', 'asc');
        $resultList = $resultList->paginate(config('constants.RECORD_PER_PAGE'));
        return view('console/options/index', compact('resultList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $option = new Option();
        $optionsGroup = OptionGroup::all();
        $option->id = 0;
        $error = [];
        return view('console/options/edit', compact('error','option' , 'optionsGroup'));
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOptionRequest $request) : RedirectResponse
    {
        $validatedData = $request->validate($request->rules());
        $option = new Option();
        $option = $this-> saveRecordOption($option , $validatedData);
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
        $optionsGroup = OptionGroup::all();
        return view('console/options/edit', compact('error','option', 'optionsGroup'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOptionRequest $request, Option $option) : RedirectResponse
    {
        $validatedData = $request->validate($request->rules());
        $option = $this-> saveRecordOption($option , $validatedData);
        return Redirect::route('options.edit', $option->id)->with('status','Option record has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Option $option) : RedirectResponse
    {
        $option->delete();
        return Redirect::route('options.index')->with('status','Option has been disabled.');
    }

    protected function saveRecordOption(Option $option , array $data) : Option
    {
        $option->name = $data['name'];
        $option->code = $data['code'];
        $option->group_id = $data['group_id'];
        $option->description = $data['description'];
        $option->save();
        return $option;
    }

    public function disable($id) : RedirectResponse
    {
        $option = Option::withTrashed()->find($id);
        if($option){
            $option->restore();
            return Redirect::route('options.index')->with('status','Record has been re-enabled.');
        }else{
            return Redirect::route('options.index')->with('status','Record has not been enabled.');
        }        
    }
    
}
