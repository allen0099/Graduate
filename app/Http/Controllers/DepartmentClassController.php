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
     * Update list objects.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'class_id.*' => ['required', 'exists:department_classes,class_id'],
            'color' => ['nullable', Rule::in(array_merge(Item::COLOR_LIST, [null]))],
        ]);

        foreach ($request->class_id as $item) {
            $dc = DepartmentClass::where('class_id', $item)->first();

            $dc->forceFill([
                'default_color' => $request->color,
            ])->save();
        }

        return response()->noContent();
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
        // won't implement
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
