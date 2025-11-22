<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // Show contact form
    public function index()
    {
        return view('frontend.contact.index');
    }

    // Submit contact form
    public function store(Request $request)
    {
        // Validate
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:general,booking,complaint,suggestion',
        ]);

        // Create inquiry
        Inquiry::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
            'type' => $request->type,
            'status' => 'new',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return back()->with('success', 'Thank you for contacting us! We will get back to you soon.');
    }
}