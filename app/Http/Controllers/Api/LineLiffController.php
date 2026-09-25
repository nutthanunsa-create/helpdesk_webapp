<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LineLiffController extends Controller
{
    public function showLoginForm()
    {
        return view('line.liff-login');
    }

    public function linkAccount(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'line_user_id' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'อีเมลหรือรหัสผ่านไม่ถูกต้อง',
            ], 401);
        }

        // Link the account
        $user->line_user_id = $request->line_user_id;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'ผูกบัญชีสำเร็จ!',
        ]);
    }
}
