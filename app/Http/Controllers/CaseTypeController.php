<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CaseType;
use Illuminate\Http\Request;

class CaseTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'list' => CaseType::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'case_name' => 'required|string',
            'description' => 'nullable|string',
        ]);
        $case_type = new CaseType();
        $case_type->case_name = $request->case_name;
        $case_type->description = $request->description;
        $case_type->save();
        return response()->json([
            'message' => 'CaseType created successfully',
            'date' => $case_type,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json([
            'data' => CaseType::findorFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'case_name' => 'required|string',
            'description' => 'nullable|string',
        ]);
        $case_type = CaseType::findorFail($id);
        $case_type->case_name = $request->case_name;
        $case_type->description = $request->description;
        $case_type->save();
        return response()->json([
            'message' => 'CaseType update successfully',
            'date' => $case_type,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $case_type = CaseType::findorFail($id);
        $case_type->delete();
        return response()->json([
            'message' => 'CaseType deleted successfully',
            'date' => $case_type,
        ]);
    }
}
