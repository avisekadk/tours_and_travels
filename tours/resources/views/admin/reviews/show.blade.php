@extends('admin.layouts.master')

@section('title', 'Review Details')
@section('page-title', 'Review Details')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6 border-b pb-4">
                <div class="flex items-center">
                    <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xl mr-4">
                        {{ substr($review->user->name, 0, 1) }}
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">{{ $review->user->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $review->user->email }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Submitted on</p>
                    <p class="font-medium text-gray-900">{{ $review->created_at->format('F d, Y H:i') }}</p>
                </div>
            </div>

            <div class="mb-6">
                <div class="flex items-center mb-3">
                    <div class="flex text-yellow-400 mr-3">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-6 h-6 {{ $i <= $review->rating ? 'fill-current' : 'text-gray-300' }}" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        @endfor
                    </div>
                    <span class="text-lg font-bold text-gray-700">{{ $review->rating }}.0</span>
                </div>
                
                @if($review->title)
                    <h4 class="text-xl font-bold text-gray-800 mb-2">{{ $review->title }}</h4>
                @endif
                
                <div class="prose max-w-none text-gray-700 bg-gray-50 p-4 rounded-lg border border-gray-100">
                    {{ $review->comment }}
                </div>
            </div>

            @if(isset($review->images) && is_array($review->images) && count($review->images) > 0)
            <div class="border-t pt-4">
                <h4 class="text-sm font-semibold text-gray-700 mb-3">Attached Images</h4>
                <div class="flex gap-4 overflow-x-auto pb-2">
                    @foreach($review->images as $image)
                        <img src="{{ asset('storage/' . $image) }}" alt="Review Image" class="h-32 w-32 object-cover rounded-lg border border-gray-200">
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Admin Reply</h3>
            
            @if($review->admin_reply)
                <div class="bg-blue-50 border border-blue-100 rounded-lg p-4">
                    <div class="flex justify-between items-start mb-2">
                        <span class="text-xs font-semibold text-blue-600 uppercase tracking-wide">You Replied</span>
                        <span class="text-xs text-gray-500">{{ $review->replied_at ? $review->replied_at->format('M d, Y') : '' }}</span>
                    </div>
                    <p class="text-gray-700">{{ $review->admin_reply }}</p>
                </div>
            @else
                <form action="{{ route('admin.reviews.reply', $review->id) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="admin_reply" class="block text-sm font-medium text-gray-700 mb-2">Write a response</label>
                        <textarea name="admin_reply" id="admin_reply" rows="4" 
                            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Thank the customer for their feedback..."></textarea>
                        @error('admin_reply')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-sm">
                            Post Reply
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>

    <div class="lg:col-span-1 space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Moderation</h3>
            
            <div class="mb-6">
                <span class="block text-sm text-gray-500 mb-1">Current Status</span>
                @if($review->approved)
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        Approved & Published
                    </span>
                @else
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                        Pending Approval
                    </span>
                @endif
            </div>

            <div class="space-y-3">
                @if(!$review->approved)
                    <form action="{{ route('admin.reviews.approve', $review->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Approve Review
                        </button>
                    </form>
                @else
                    <form action="{{ route('admin.reviews.reject', $review->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                            Reject / Unpublish
                        </button>
                    </form>
                @endif

                <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Are you sure? This cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full py-2 border border-red-500 text-red-600 rounded-lg hover:bg-red-50 transition flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Delete Permanently
                    </button>
                </form>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Tour Reviewed</h3>
            
            @if($review->tour->featured_image)
                <img src="{{ asset('storage/' . $review->tour->featured_image) }}" alt="{{ $review->tour->title }}" class="w-full h-32 object-cover rounded-lg mb-3">
            @else
                <div class="w-full h-32 bg-gray-200 rounded-lg mb-3 flex items-center justify-center text-gray-400">No Image</div>
            @endif
            
            <h4 class="font-bold text-gray-900 mb-1">
                <a href="{{ route('admin.tours.show', $review->tour->id) }}" class="hover:text-blue-600 hover:underline">
                    {{ $review->tour->title }}
                </a>
            </h4>
            <div class="flex items-center text-sm text-gray-500 mb-3">
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    {{ $review->tour->destination->name ?? 'N/A' }}
                </span>
            </div>
            
            <a href="{{ route('tours.show', $review->tour->slug) }}" target="_blank" class="text-sm text-blue-600 font-medium hover:text-blue-800 flex items-center">
                View Tour on Frontend &rarr;
            </a>
        </div>
    </div>
</div>
@endsection