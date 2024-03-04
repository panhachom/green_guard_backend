<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthApiController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.'
            ]);
        }

        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password.'
            ]);
        }
        $user->token = $user->createToken('myApp')->plainTextToken;
        return response()->json([
            'success' => true,
            'message' => 'User logged in successfully.',
            'data'    => $user
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'     => 'required',
            'email'    => 'required|email',
            'password' => 'required'
        ]);
        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->createToken('token')->accessToken;
        return response()->json([
            'success' => true,
            'message' => 'User register successfully.'
        ]);
    }
}
