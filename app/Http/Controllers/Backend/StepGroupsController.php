<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StepGroupStoreRequest;
use App\Models\Step;
use App\Models\StepGroup;

class StepGroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $step_groups = StepGroup::orderBy('id', 'DESC')->get();

        return view('backend.step_groups.list', compact(
            'step_groups'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $arrSteps = Step::pluck('name', 'id')->toArray();

        return view('backend.step_groups.create', compact(
            'arrSteps'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StepGroupStoreRequest $request)
    {
        $data = $request->input();
        StepGroup::create($data);
        
        return redirect()->route('backend.step_groups.list');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(StepGroup $step_group)
    {
        $arrSteps = Step::pluck('name', 'id')->toArray();

        return view('backend.step_groups.edit', compact(
            'step_group', 'arrSteps'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StepGroup $step_group, StepGroupStoreRequest $request)
    {
        $data = $request->input();
        $step_group->update($data);

        return redirect()->route('backend.step_groups.list');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(StepGroup $step_group)
    {
        $step_group->delete();
        return redirect()->route('backend.step_groups.list');
    }

}
