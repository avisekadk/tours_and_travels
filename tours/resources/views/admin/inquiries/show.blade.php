@extends('admin.layouts.master')

@section('title', 'View Inquiry')
@section('page-title', 'Inquiry Details')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6 border-b pb-4">
                <div>
                    <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $inquiry->subject }}</h3>
                    <div class="flex items-center gap-2">
                        <span class="px-2 py-0.5 rounded text-xs font-semibold bg-gray-100 text-gray-600 border border-gray-200">
                            {{ ucfirst($inquiry->type) }}
                        </span>
                        <span class="text-sm text-gray-500">{{ $inquiry->created_at->format('F d, Y h:i A') }}</span>
                    </div>
                </div>
                <div class="text-right">
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                        @if($inquiry->status === 'new') bg-blue-100 text-blue-800
                        @elseif($inquiry->status === 'replied') bg-green-100 text-green-800
                        @elseif($inquiry->status === 'closed') bg-gray-100 text-gray-800
                        @else bg-yellow-100 text-yellow-800 @endif">
                        {{ ucfirst(str_replace('_', ' ', $inquiry->status)) }}
                    </span>
                </div>
            </div>

            <div class="bg-gray-50 rounded-lg p-4 mb-6 border border-gray-100">
                <p class="text-gray-800 whitespace-pre-wrap leading-relaxed">{{ $inquiry->message }}</p>
            </div>

            @if($inquiry->admin_reply)
            <div class="bg-blue-50 border border-blue-100 rounded-lg p-4 mt-6">
                <div class="flex justify-between items-start mb-2">
                    <span class="text-xs font-semibold text-blue-600 uppercase tracking-wide">Reply Sent</span>
                    <span class="text-xs text-gray-500">
                        {{ $inquiry->replied_at ? $inquiry->replied_at->format('M d, Y H:i') : '' }}
                        @if($inquiry->repliedByUser)
                            by {{ $inquiry->repliedByUser->name }}
                        @endif
                    </span>
                </div>
                <p class="text-gray-700 whitespace-pre-wrap">{{ $inquiry->admin_reply }}</p>
            </div>
            @endif
        </div>

        @if($inquiry->status !== 'closed')
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Send Reply</h3>
            <form action="{{ route('admin.inquiries.reply', $inquiry->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <textarea name="admin_reply" rows="6" 
                        class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 font-sans"
                        placeholder="Write your response here. This will be sent to the user via email..."
                        required></textarea>
                    @error('admin_reply')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-sm flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                        Send Reply
                    </button>
                </div>
            </form>
        </div>
        @endif
    </div>

    <div class="lg:col-span-1 space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Sender Details</h3>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-xs text-gray-500 uppercase">Name</label>
                    <p class="font-medium text-gray-900">{{ $inquiry->name }}</p>
                </div>
                <div>
                    <label class="block text-xs text-gray-500 uppercase">Email</label>
                    <a href="mailto:{{ $inquiry->email }}" class="font-medium text-blue-600 hover:underline flex items-center">
                        {{ $inquiry->email }}
                    </a>
                </div>
                <div>
                    <label class="block text-xs text-gray-500 uppercase">Phone</label>
                    <p class="font-medium text-gray-900">{{ $inquiry->phone ?? 'Not provided' }}</p>
                </div>
                <div class="pt-2 border-t border-gray-100">
                    <label class="block text-xs text-gray-500 uppercase">IP Address</label>
                    <p class="text-sm font-mono text-gray-600">{{ $inquiry->ip_address ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Actions</h3>
            
            <div class="flex flex-col gap-3">
                @if($inquiry->status !== 'closed')
                    <form action="{{ route('admin.inquiries.close', $inquiry->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition flex items-center justify-center" onclick="return confirm('Are you sure you want to close this inquiry?');">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Mark as Closed
                        </button>
                    </form>
                @endif

                <form action="{{ route('admin.inquiries.destroy', $inquiry->id) }}" method="POST" onsubmit="return confirm('Are you sure? This action cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full py-2 border border-red-500 text-red-600 rounded-lg hover:bg-red-50 transition flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Delete Inquiry
                    </button>
                </form>

                <a href="{{ route('admin.inquiries.index') }}" class="block w-full text-center py-2 text-sm text-gray-600 hover:text-gray-900 mt-2">
                    &larr; Back to List
                </a>
            </div>
        </div>
    </div>
</div>
@endsection