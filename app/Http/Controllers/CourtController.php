<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Court;
use App\Models\Courttype;
use Illuminate\Http\Request;

class CourtController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'list' => Court::with('courttype')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'courttype_id' => 'required | exists:court_types,id',
            'court_name' => 'required |string ',
            'address' => 'required |string ',
            'email' => 'required |email ',
            'status' => 'required |in:active,inactive',
        ]);
        $court = Court::create([
            'courttype_id' => $request->courttype_id,
            'court_name' => $request->court_name,
            'address' => $request->address,
            'email' => $request->email,
            'status' => $request->status,
        ]);
        return response()->json([
            'data' => $court->load('courttype'),
            'message' => 'Court has been created successfully.'
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $court = Court::findorFail($id);
        return response()->json([
            "data" => $court->load(["courtType"])
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {   $court = Court::findorFail($id);
        $request->validate([
            'courttype_id' => 'required | exists:court_types,id',
            'court_name' => 'required |string ',
            'address' => 'required |string ',
            'email' => 'required |email ',
            'status' => 'required |in:active,inactive',
        ]);
        $court->update([
            'courttype_id' => $request->courttype_id,
            'court_name' => $request->court_name,
            'address' => $request->address,
            'email' => $request->email,
            'status' => $request->status,
        ]);
        return response()->json([
            'data' => $court->load('courttype'),
            'message' => 'Court has been update successfully.'
        ],201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $court = Court::findorFail($id);
        $court->delete();
        return response()->json([
            'data' => $court->load('courttype'),
            'message' => 'Court has been deleted successfully.'
        ]);
    }
}
