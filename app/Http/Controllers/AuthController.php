<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            "list" => User::with('staff')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
//            'user_id' => 'required|exists:users,id|unique:staff,user_id',
            'staff_name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'gender' => 'required|in:Male,Female',
            'date_of_birth' => 'nullable|date',
            'join_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:join_date',
            'details' => 'nullable|string|max:500',
            'created_by' => 'nullable|string|max:255',
            'updated_by' => 'nullable|string|max:255',
            'status' => 'required|in:Active,Disabled',

            'user_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
        ]);
        $user = User::create([
            'user_name' => $request->user_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => $request->status
        ]);
        $imageUrl = null;
        if ($request->hasFile('image')) {
            $imageUrl= $request->file('image')->store('profile', 'public');
        }
        Staff::create([
            'user_id' => $user->id,
            'staff_name' => $request->staff_name,
            'title' => $request->title,
            'image' => $imageUrl,
            'phone' => $request->phone,
            'address' => $request->address,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'join_date' => $request->join_date,
            'end_date' => $request->end_date,
            'details' => $request->details,
            'created_by' => $request->created_by,
            'updated_by' => $request->updated_by
        ]);
        return response()->json([
            "data" => $user->load('staff'),
            "message" => "User created successfully"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return response()->json([
            "list" => $user -> load('staff')
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
//            'user_id' => 'required|exists:users,id|unique:staff,user_id',
            'staff_name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'gender' => 'required|in:Male,Female',
            'date_of_birth' => 'nullable|date',
            'join_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:join_date',
            'details' => 'nullable|string|max:500',
            'created_by' => 'nullable|string|max:255',
            'updated_by' => 'nullable|string|max:255',
            'status' => 'required|in:Active,Disable',

            'user_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'password' => 'required|string|min:6',
        ]);
        $user = User::findOrFail($id);
        $user->update([
            'user_name' => $request->user_name,
            'email' => $request->email,
            'password' => $request->password,
            'status' => $request->status
        ]);
        $staff = Staff::where('user_id', $id)->first();
        if ($request->hasFile('image')) {
            if ($staff->image) {
                Storage::disk('public')->delete($staff->image);
            }
            $staff-> image = $request->file('image')->store('profile', 'public');
        }
        $staff->update([
            'staff_name' => $request->staff_name,
            'title' => $request->title,
            'phone' => $request->phone,
            'address' => $request->address,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'join_date' => $request->join_date,
            'end_date' => $request->end_date,
            'details' => $request->details,
            'updated_by' => $request->updated_by,
        ]);
//        $user->staff()->update([
//            'staff_name' => $request->staff_name,
//            'title' => $request->title,
//            'image' => $imageUrl,
//            'phone' => $request->phone,
//            'address' => $request->address,
//            'gender' => $request->gender,
//            'date_of_birth' => $request->date_of_birth,
//            'join_date' => $request->join_date,
//            'end_date' => $request->end_date,
//            'details' => $request->details,
//            'updated_by' => $request->updated_by,
//        ]);
        return response()->json([
            "data" => $user->load('staff'),
            "message" => "User update successfully"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user -> delete();
        return response()->json([
            "message" => "User has been deleted"
        ]);
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|String|email',
            'password' => 'required|String',
        ]);
        if (!$token = JWTAuth::attempt($request->only('email', 'password'))) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $user = JWTAuth::user();
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        if ($user->status !== 'active') {
            return response()->json(['error' => 'Account disabled'], 403);
        }
        $expiration = JWTAuth::factory()->getTTL();
        // $expires_at = now()->addMinutes($expiration)->toDateTimeString();
        $expires_at = now()->addMinutes($expiration)->format('Y-m-d h:i:s A');
        return response()->json([
            "access_token" => $token,
            'expires_at' => $expires_at,
            'user' => $user,
        ]);
    }
}
