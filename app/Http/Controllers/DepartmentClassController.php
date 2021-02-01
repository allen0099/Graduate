<?php

namespace App\Http\Controllers;

use App\Models\DepartmentClass;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DepartmentClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DepartmentClass::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // won't implement
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return DepartmentClass::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'class_id' => ['required', 'exists:department_classes,class_id'],
            'color' => ['required', Rule::in(Item::COLOR_LIST)],
        ]);

        $dc = DepartmentClass::where('class_id', $request->class_id)->first();

        $dc->forceFill([
            'default_color' => $request->color,
        ])->save();

        return $dc->fresh();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // won't implement
    }
}
