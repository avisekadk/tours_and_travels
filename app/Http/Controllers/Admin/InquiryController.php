<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InquiryController extends Controller
{
    // Show all inquiries
    public function index(Request $request)
    {
        $query = Inquiry::query();

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by type
        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }

        $inquiries = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.inquiries.index', compact('inquiries'));
    }

    // Show single inquiry
    public function show($id)
    {
        $inquiry = Inquiry::findOrFail($id);

        // Mark as in progress if new
        if ($inquiry->status === 'new') {
            $inquiry->status = 'in_progress';
            $inquiry->save();
        }

        return view('admin.inquiries.show', compact('inquiry'));
    }

    // Reply to inquiry
    public function reply(Request $request, $id)
    {
        $request->validate([
            'admin_reply' => 'required|string',
        ]);

        $inquiry = Inquiry::findOrFail($id);
        $inquiry->admin_reply = $request->admin_reply;
        $inquiry->replied_by = Auth::id();
        $inquiry->replied_at = now();
        $inquiry->status = 'replied';
        $inquiry->save();

        // Here you can send email to user with the reply

        return back()->with('success', 'Reply sent successfully!');
    }

    // Delete inquiry
    public function destroy($id)
    {
        $inquiry = Inquiry::findOrFail($id);
        $inquiry->delete();

        return redirect()->route('admin.inquiries.index')
            ->with('success', 'Inquiry deleted successfully!');
    }
}