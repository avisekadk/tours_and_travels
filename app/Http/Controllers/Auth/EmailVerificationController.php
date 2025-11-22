<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class EmailVerificationController extends Controller
{
    // Show email verification notice
    public function notice()
    {
        // If already verified, redirect
        if (Auth::user()->email_verified_at) {
            return redirect()->route('profile.dashboard');
        }

        return view('auth.verify-email');
    }

    // Verify email
    public function verify(Request $request, $id, $hash)
    {
        // Find user
        $user = User::findOrFail($id);

        // Check if hash matches
        if (!hash_equals((string) $hash, sha1($user->email))) {
            abort(403, 'Invalid verification link.');
        }

        // Check if already verified
        if ($user->email_verified_at) {
            return redirect()->route('profile.dashboard')
                ->with('info', 'Email already verified.');
        }

        // Mark as verified
        $user->email_verified_at = now();
        $user->save();

        return redirect()->route('profile.dashboard')
            ->with('success', 'Email verified successfully!');
    }

    // Resend verification email
    public function resend(Request $request)
    {
        // Check if already verified
        if (Auth::user()->email_verified_at) {
            return redirect()->route('profile.dashboard');
        }

        // Send verification email (you'll need to create this mail class later)
        // Mail::to(Auth::user()->email)->send(new EmailVerificationMail(Auth::user()));

        return back()->with('success', 'Verification link sent!');
    }
}