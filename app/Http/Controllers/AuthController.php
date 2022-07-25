<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

// use Carbon\Carbon;

class AuthController extends Controller
{
    /**
     * Register User
     * @param Request $request
     * @return User
     */
    public function register(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
                'role_id' => 'required',
            ]);

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation Error',
                    'errors' => $validateUser->errors()
                ], 401);
            }
    
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $request->role_id,
            ]);
    
            return response()->json([
                'status' => true,
                'Message' => 'User has been registered successfully!'
            ], 200);  

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'Message' => $e->getMessage(),
                'errors' => $validateUser->errors()
            ], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|string'
            ]);

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation Error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email or Password is incorrect!'
                ], 401);
            }
    
            $user = User::where('email', $request->email)->first();
    
            return response()->json([
                'status' => true,
                'user' => Auth::user(),
                'Message' => 'User Logged In Successfully!',
                'token' => $user->createToken('Personal Access Token')->plainTextToken
            ], 200);  

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'Message' => $e->getMessage(),
                'errors' => $validateUser->errors()
            ], 500);
        }
    }
}