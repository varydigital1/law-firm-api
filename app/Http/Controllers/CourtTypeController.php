<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CourtType;
use Illuminate\Http\Request;

class CourtTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courtTypes = CourtType::all();
        return response()->json([
            'list' => $courtTypes,
            'total' => $courtTypes ->count(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'courttype_name' => 'required|string',
            'description' => 'nullable|string',
        ]);
        $court_Type = new CourtType();
        $court_Type->courttype_name = $request->courttype_name;
        $court_Type->description = $request->description;
        $court_Type->save();
        return response()->json([
            "message" => "create court type successfully",
            "data" => $court_Type,
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json([
            'data' => CourtType::findorFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'courttype_name' => 'required|string',
            'description' => 'nullable|string',
        ]);
        $court_Type = CourtType::findorFail($id);
        $court_Type->courttype_name = $request->courttype_name;
        $court_Type->description = $request->description;
        $court_Type->save();
        return response()->json([
            "message" => "Update court type successfully",
            "data" => $court_Type,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $court_Type = CourtType::findorFail($id);
        $court_Type->delete();
        return response()->json([
            "message" => "Delete court type successfully",
            "data" => $court_Type,
        ]);
    }
}
