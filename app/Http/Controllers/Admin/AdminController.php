<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(5);
        return view('admin.index',compact('users'));
    }

    public function store(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

       $publicId = (string) Str::uuid();
        // Creating User
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'public_id' => $publicId,
            'status' => 1
        ]);

        return response()->json(['message' => 'User created successfully!', 'user' => $user], 201);
    }

    public function update(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        // Validation with unique email check that excludes current user
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'nullable|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Prepare update data
        $userData = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
        ];

        // Only add password if it's provided
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        // Updating User
        try {
            $user->update($userData);
            return response()->json(['message' => 'User updated successfully!', 'user' => $user], 200);
        } catch (\Exception $e) {
            \Log::error('Error updating user:', ['exception' => $e->getMessage()]);
            return response()->json(['error' => 'Error updating user'], 500);
        }
    }

    public function destroy($userId)
    {
        $user = User::findOrFail($userId);
        $user->roles()->detach();
        $user->delete();
        return response()->json(['message' => 'user has been deleted successfully!']);
    }
}

