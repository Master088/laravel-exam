<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Dashboard for authenticated user
    public function dashboard(Request $request)
    {
        return response()->json(['user' => $request->user()]);
    }

    // List all users (Admin only)
    public function index()
    {
        return response()->json(User::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|confirmed',
            'role' => 'required|in:user,admin',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return response()->json($user, 201);
    }

    public function show(User $user)
    {
        return response()->json($user);
    }

    // Update user
    public function update(Request $request, $id)
    {
        // Find the user
        $user = User::findOrFail($id);

        // Validate input
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'role' => 'required|in:user,admin',
        ]);

        // If password is provided, hash it
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        // Update user
        $user->update($data);

        // Return JSON response
        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user
        ]);
    }

public function destroy(User $user)
{
    $user->delete();

    return response()->json(['message' => 'User deleted successfully']);
}

}