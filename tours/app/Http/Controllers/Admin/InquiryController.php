<?php
// app/Http/Controllers/Admin/InquiryController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function index(Request $request)
    {
        $query = Inquiry::query();

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        $inquiries = $query->latest()->paginate(20);

        return view('admin.inquiries.index', compact('inquiries'));
    }

    public function show(Inquiry $inquiry)
    {
        return view('admin.inquiries.show', compact('inquiry'));
    }

    public function reply(Request $request, Inquiry $inquiry)
    {
        $validated = $request->validate([
            'admin_reply' => 'required|string|max:2000',
        ]);

        $inquiry->update([
            'admin_reply' => $validated['admin_reply'],
            'replied_by' => auth()->id(),
            'replied_at' => now(),
            'status' => 'replied',
        ]);

        // Here you would send email to inquirer

        return back()->with('success', 'Reply sent successfully!');
    }

    public function close(Inquiry $inquiry)
    {
        $inquiry->update(['status' => 'closed']);

        return back()->with('success', 'Inquiry closed successfully!');
    }

    public function destroy(Inquiry $inquiry)
    {
        $inquiry->delete();

        return redirect()->route('admin.inquiries.index')
            ->with('success', 'Inquiry deleted successfully!');
    }
}