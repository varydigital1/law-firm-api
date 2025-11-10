<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceType;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
//            "list" => Service::all()
            "list" => Service::with("servicetype")->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "servicetype_id" => "required|exists:service_types,id",
            "service_name" => "required|string",
            "description" => "nullable|string",
            "created_by" => "required",
            'status' => 'required|in:active,inactive',
        ]);
        $service = Service::create([
            "servicetype_id" => $request->servicetype_id,
            "service_name" => $request->service_name,
            "description" => $request->description,
            "created_by" => $request->created_by,
            "status" => $request ->status
        ]);
        return response()->json([
            "data" => $service->load("servicetype"),
            "message" => "Service created successfully",
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $service = Service::findorFail($id);
        return response()->json([
            "data" => $service->load(["servicetype"])
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $service = Service::findorFail($id);
        $request->validate([
            "servicetype_id" => "required|exists:service_types,id",
            "service_name" => "required|string",
            "description" => "nullable|string",
            "created_by" => "required",
            'status' => 'required|in:active,inactive',
        ]);
        $service -> update([
            "servicetype_id" => $request->servicetype_id,
            "service_name" => $request->service_name,
            "description" => $request->description,
            "created_by" => $request->created_by,
            "status" => $request ->status
        ]);
        return response()->json([
            "data" => $service->load("servicetype"),
            "message" => "Service updates successfully",
        ],201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $service = Service::findorFail($id);
        $service->delete();
        return response()->json([
            "data" => $service->load("servicetype"),
            "message" => "Service deleted successfully"
        ]);
    }
}
