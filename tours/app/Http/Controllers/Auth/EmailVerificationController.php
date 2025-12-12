<?php
// app/Http/Controllers/Auth/EmailVerificationController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class EmailVerificationController extends Controller
{
    public function notice()
    {
        if (auth()->user()->email_verified_at) {
            return redirect()->route('profile.dashboard');
        }

        return view('auth.verify-email');
    }

    public function verify($id, $hash)
    {
        $user = User::findOrFail($id);

        // Verify hash matches
        if (!hash_equals((string) $hash, sha1($user->email))) {
            abort(403, 'Invalid verification link.');
        }

        // Check if already verified
        if ($user->email_verified_at) {
            return redirect()->route('profile.dashboard')->with('info', 'Email already verified.');
        }

        // Mark as verified
        $user->email_verified_at = now();
        $user->save();

        return redirect()->route('profile.dashboard')->with('success', 'Email verified successfully!');
    }

    public function resend(Request $request)
    {
        if ($request->user()->email_verified_at) {
            return redirect()->route('profile.dashboard');
        }

        // Here you would send the verification email again
        // Mail::to($request->user())->send(new EmailVerificationMail($request->user()));

        return back()->with('success', 'Verification link sent!');
    }
}