<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cases;
use Carbon\Carbon;
use App\Models\Casetype;
use Illuminate\Http\Request;

class CasesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'list' => Cases::with('court', 'casetype')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'casetype_id' => 'required|exists:case_types,id',
            'court_id' => 'required|exists:courts,id',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:open,pending,closed',

        ]);
        $cases= Cases::create([
            'casetype_id' => $request->casetype_id,
            'court_id' => $request->court_id,
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request -> status,
            'created_at' => Carbon::now()
        ]);
        return response()->json([
            'data' => $cases->load('court', 'casetype'),
            'message' => 'Court has been created successfully.'
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cases = Cases::findorFail($id);
        return response()->json([
            "data" => $cases->load(['court', 'casetype'])
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'casetype_id' => 'required|exists:case_types,id',
            'court_id' => 'required|exists:courts,id',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:open,pending,closed',

        ]);
        $cases = Cases::findorFail($id);
        $cases ->update([
            'casetype_id' => $request->casetype_id,
            'court_id' => $request->court_id,
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request -> status,
        ]);
        return response()->json([
            'data' => $cases->load('court', 'casetype'),
            'message' => 'Court has been update successfully.'
        ],201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cases = Cases::findorFail($id);
        $cases ->delete();
        return response()->json([
            'data' => $cases->load('court', 'casetype'),
            'message' => 'Court has been deleted successfully.'
        ]);
    }
}
