<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validate login request
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        // Find the user
        $user = User::where('email', $validated['email'])
            // ->whereNull('deleted_at')
            ->first();

        // Check whether user exists
        if (!$user) {
            return response()->json([
                'message' => 'Invalid email or password.',
            ], 401);
        }

        // Check password
        if (!Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'message' => 'Invalid email or password.',
            ], 401);
        }

        // Check whether tenant is active
        if ($user->tenant_id !== null && !$user->tenant?->is_active) {
            return response()->json([
                'message' => 'Your company account is inactive.',
                ], 403);
        }

        // Create Sanctum token
        $token = $user->createToken('auth-token')->plainTextToken;

        // Return login response
        return response()->json([
            'message' => 'Login successful.',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'user_type' => $user->user_type,
                'tenant_id' => $user->tenant_id,
            ],
        ], 200);
    }
}
