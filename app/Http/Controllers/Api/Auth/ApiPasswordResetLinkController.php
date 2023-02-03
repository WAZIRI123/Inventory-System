<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ApiPasswordResetLinkController extends Controller
{
    public function sendPasswordResetLink(Request $request)
    {
        $validatedData = $request->validate([
            'email' => ['required', 'email'],
        ]);
    
        $resetData = Password::sendResetLink(
            ['email' => $validatedData['email']]
        );
if (is_array($resetData)) {
    if ($resetData['status'] == Password::RESET_LINK_SENT) {
        return response()->json([
            'message' => __($resetData['status']),
            'token'   => $resetData['token'],         
         ], 200);
    } else {
        return response()->json([
            'message' => __($resetData['status']),
        ], 400);
    }
}else {
    return response()->json([
        'throttled' =>'Too many password reset attempts. Please try again later.',
    ]);
}


    }
    
}
