<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required|string',
                'password' => 'required|string',
            ]);

            // Try to authenticate as admin
            if (Auth::guard('admin')->attempt(['admin_id' => $request->username, 'password' => $request->password])) {
                // Admin authentication passed
                return response()->json([
                    'success' => true,
                    'redirect' => '/dashboard'
                ]);
            }

            // Try to authenticate as tenant
            // First check if the tenant exists and is not archived
            $tenant = \App\Models\Tenant::where('tenant_id', $request->username)
                ->where(function($query) {
                    $query->where('status', '!=', 'Archived')
                          ->orWhereNull('status');
                })
                ->first();

            if ($tenant && Auth::guard('tenant')->attempt(['tenant_id' => $request->username, 'password' => $request->password])) {
                // Tenant authentication passed
                return response()->json([
                    'success' => true,
                    'redirect' => '/tenant/homepage'
                ]);
            }

            // Check if tenant exists but is archived
            $archivedTenant = \App\Models\Tenant::where('tenant_id', $request->username)
                ->where('status', 'Archived')
                ->exists();

            if ($archivedTenant) {
                return response()->json([
                    'success' => false,
                    'errors' => [
                        'username' => ['This account has been archived and cannot be used.']
                    ]
                ], 422);
            }

            // Try default web guard as fallback
            if (Auth::attempt(['email' => $request->username, 'password' => $request->password])) {
                // Authentication passed
                return response()->json([
                    'success' => true,
                    'redirect' => '/dashboard'
                ]);
            }

            // Authentication failed - return error response instead of throwing exception
            return response()->json([
                'success' => false,
                'errors' => [
                    'username' => ['The provided credentials are incorrect.']
                ]
            ], 422);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Login error: ' . $e->getMessage());

            // Return a more specific error message
            return response()->json([
                'success' => false,
                'errors' => [
                    'username' => ['An error occurred: ' . $e->getMessage()]
                ]
            ], 500);
        }
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        // Logout from all guards
        Auth::guard('web')->logout();
        Auth::guard('admin')->logout();
        Auth::guard('tenant')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
