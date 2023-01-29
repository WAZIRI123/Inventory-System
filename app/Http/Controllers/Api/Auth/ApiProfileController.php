<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiProfileController extends Controller
{
        /**
         * Display the user's profile information.
         */
        public function show(User $user): JsonResponse
        {
            return response()->json([
                'user' => $user,
            ]);
        }
    
    
        /**
         * Update the user's profile information.
         */
        public function update(ProfileUpdateRequest $request): JsonResponse
        {
            $request->user()->fill($request->validated());
    
            if ($request->user()->isDirty('email')) {
                $request->user()->email_verified_at = null;
            }
    
            $request->user()->save();
    
            return response()->json([
                'user' =>  $request->user(),
                'message' => 'Profile updated successfully.'
            ], 200);
        }
    
        /**
         * Delete the user's account.
         */
        public function destroy(Request $request): JsonResponse
        {
            $request->validate([
                'password' => ['required', 'current-password'],
            ]);
    
            $user = $request->user();
    
            Auth::logout();
    
            $user->delete();
    
            return response()->json([
                'message' => 'Account deleted successfully.'
            ], 200);
        }
    }
    

