<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
{
    \Log::info('Register Request Data:', $request->all()); // Debug input request

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6',
        'role' => 'required|in:guru,siswa'
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role
    ]);

    \Log::info('User Created:', $user->toArray()); // Debug apakah user tersimpan

    return response()->json([
        'message' => 'User registered successfully',
        'user' => $user
    ], 201);
}


public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.']
        ]);
    }

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'Login successful',
        'access_token' => $token,
        'token_type' => 'Bearer',
        'user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role, // Tambahkan role untuk frontend
        ]
    ]);
}

public function logout(Request $request)
{
    $request->user()->tokens()->delete(); // Hapus semua token user

    return response()->json([
        'success' => true,
        'message' => 'Logout berhasil!'
    ]);
}
// ✅ API untuk mendapatkan current user yang sedang login
public function currentUser(Request $request)
{
    return response()->json([
        'user' => $request->user()
    ]);
}

}
