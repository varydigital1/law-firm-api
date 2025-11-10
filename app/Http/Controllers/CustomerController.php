<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use function Webmozart\Assert\Tests\StaticAnalysis\resource;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'list' => Customer::where('status', 'active')->get() //Get for data active
//           'data' => Customer::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required | string',
            'last_name'=> 'required | string',
            'gender' => 'nullable | in:male,female,other',
            'birth_date' => 'nullable | date',
            'nationality' => 'nullable | string',
            'id_card_number' => 'required | integer',
            'email' => 'required | email |unique:customers,email',
            'phone' => 'required | string',
            'address' => 'nullable | string',
            'created_by' => 'required | string',
            'status' => 'required | in:active,deleted'

        ]);
        $customer = Customer::Create([
            'first_name' => $request->first_name,
            'last_name' => $request -> last_name,
            'gender' => $request -> gender,
            'birth_date' => $request->birth_date,
            'nationality' => $request->nationality,
            'id_card_number' => $request->id_card_number,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'created_by' => $request->created_by,
//            'created_by' => auth()->id() ?? $request->created_by, // safer
            'status' => $request->status,
//            'status' => 'active',
        ]);

//        $customer->created_by = auth()->user()->id;
        return response()->json([
            'data' => $customer,
            'message' => 'Customer created successfully.'
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customer = Customer::where('id', $id)
                    ->where('status', 'active')
                    ->firstOrFail(); // throws 404 if not found
        return response()->json([
            "data" => $customer
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'first_name' => 'required | string',
            'last_name'=> 'required | string',
            'gender' => 'nullable | in:male,female,other',
            'birth_date' => 'nullable | date',
            'nationality' => 'nullable | string',
            'id_card_number' => 'required | integer',
            'email' => 'required | email',
            'phone' => 'required | string',
            'address' => 'nullable | string',
            'created_by' => 'required | string',
            'status' => 'required | in:active,deleted'

        ]);
        $customer = Customer::where('id', $id)
            ->where('status', 'active')
            ->firstOrFail();
        $customer -> update([
            'first_name' => $request->first_name,
            'last_name' => $request -> last_name,
            'gender' => $request -> gender,
            'birth_date' => $request->birth_date,
            'nationality' => $request->nationality,
            'id_card_number' => $request->id_card_number,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'created_by' => $request->created_by,
//            'created_by' => auth()->id() ?? $request->created_by, // safer
            'status' => 'active',
        ]);
        return response()->json([
            'data' => $customer,
            'message' => 'Customer update successfully.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::where('id', $id)
            ->where('status', 'active')
            ->firstOrFail();
//        way1
        // Directly set status to 'deleted'
//        Customer::withoutEvents(function() use ($customer) {
//            $customer->status = 'deleted';
//            $customer->save();
//        });
        //way2
        $customer->update([
            'status' => 'deleted'
        ]);
        return response()->json([
            'data' => $customer,
            'message' => 'Customer deleted successfully.'
        ]);
    }
    // Restore a deleted customer
    public function restore($id)
    {
        $customer = Customer::where('id', $id)
            ->where('status', 'deleted')
            ->firstOrFail();
        $customer->update([
            'status' => 'active'
        ]);
        return response()->json([
            'message' => 'Customer restored successfully'
        ]);
    }
}
