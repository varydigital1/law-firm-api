<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ServiceType;
use Illuminate\Http\Request;
use function Webmozart\Assert\Tests\StaticAnalysis\resource;

class ServiceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $service_types = ServiceType::all();
        return response()->json([
            'list' => $service_types,
            'total' => $service_types->count()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'servicetype_name' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);
        $service_types = new ServiceType();
        $service_types->servicetype_name = $request->servicetype_name;
        $service_types->description = $request->description;
        $service_types->status = $request->status;
        $service_types->save();
        return response()->json([
            "message" => "create service type successfully",
            "data" => $service_types,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json([
            "data" => ServiceType::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'servicetype_name' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);
        $service_types = ServiceType::findorFail($id);
        $service_types->servicetype_name = $request->servicetype_name;
        $service_types->description = $request->description;
        $service_types->status = $request->status;
        $service_types->save();
        return response()->json([
            "message" => "update service type successfully",
            "data" => $service_types,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $service_types = ServiceType::findorFail($id);
        $service_types->delete();
        return response()->json([
            "message" => "delete service type successfully",
            "data" => $service_types,
        ]);
    }
}
